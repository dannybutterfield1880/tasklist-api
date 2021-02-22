<?php


namespace Core\Utils;


use Brick\Http\Exception\HttpMethodNotAllowedException;
use Brick\Http\Request;
use Brick\Http\Response;
use Core\Controller\BaseController;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\ORMException;
use Exception;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validation;

class Bootstrap
{
    public $controller;

    public $method;

    public $params;

    public $docBlock;

    /**
     * @var Container $container
     */
    private $container;


    public function __construct()
    {
        [$controller, $method, $params] = is_null($_GET['url']) ? 'cli' :parseUrlString($_GET['url']); //variables to be stored as properties to AppContainer

        $this->controller = $controller;
        $this->method = $method;
        $this->params = $params;

        $this->container = Bootstrap::buildAppContainer();
    }

    /**
     * execute method on current controller
     */
    public function execute()
    {
        /** @var ReflectionClass|BaseController  $controller */
        $controller = new $this->controller($this->container);

        try {
            $validator = new MethodValidator($this->container, $this->controller, $this->method);

            $validator->validateMethod(); //checks if method can use method i.e GET | POST | PATCH | DELETE

            $loggedInUser = $validator->validateAuthToken(); //checks if auth token is needed and returns user if successful

            if (isset($loggedInUser)) {
                $this->container->setUser($loggedInUser);
            }

            $method = $this->method;

            $controller->$method(...$this->params);

        } catch(HttpMethodNotAllowedException $exception) {
            dump($exception);
            die();
        } catch (Exception $e) {
            if ($e->getMessage() === 'Expired token') {
                return $this->container->getResponse()
                    ->withStatusCode(403)
                    ->withContent(json_encode(  [
                        'message' => 'Your token has expired',
                        'status' => 'error'
                    ]))
                    ->send();
            }
            dump($e);
            die();
        }
    }

    /**
     * Build up the container to give the controllers all necessary functionality
     */
    static public function buildAppContainer(): Container
    {
        try {
            $entityManager = makeEntityManager();
        } catch (ORMException $e) {
            dump($e);
            die();
        }

        $serializer = Bootstrap::makeSerializer();

        $logger = Bootstrap::makeLogger();

        $validator = Validation::createValidator();

        $request = new Request;
        $request = $request->getCurrent();

        $response = new Response;

//        header('Content-Type: application/json');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST,GET,DELETE,PUT,OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN, Access-Control-Allow-Origin');
        header('Access-Control-Expose-Headers: Authorization, authenticated');

        return new Container($entityManager, $request, $response, $serializer, $validator, $logger);
    }

    static public function makeSerializer(): Serializer
    {
        // all callback parameters are optional (you can omit the ones you don't use)
        $dateCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : null;
        };

        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'createdAt' => $dateCallback,
                'updatedAt' => $dateCallback,
                'lastSignOn' => $dateCallback
            ],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        //make serializer
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [
            new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext),
            new GetSetMethodNormalizer($classMetadataFactory, null, null, null, null, $defaultContext)
        ];

        return new Serializer($normalizers, $encoders);
    }

    static public function makeLogger(): Logger
    {
        $logger = new Logger('task-lists');
        $logger->pushHandler(new StreamHandler(__DIR__.'/var/logs/error.log', Logger::DEBUG));

        return $logger;
    }

    public function getAppContainer(): Container
    {

        return $this->container;
    }
}

<?php


namespace Core\Utils;


use Brick\Http\Exception\HttpMethodNotAllowedException;
use http\Env\Request;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;

class MethodValidator
{
    protected $docBlock;

    protected $container;

    protected $controller;

    protected $method;

    public function __construct(Container $container, $controller, $method)
    {
        $this->container = $container;
        $this->controller = $controller;
        $this->method = $method;

        $this->parseDocComment();
    }

    public function parseDocComment()
    {
        $reflectionClass = new ReflectionClass($this->controller);

        $docComment = $reflectionClass->getMethod($this->method)->getDocComment();

        $factory  = DocBlockFactory::createInstance();
        $docBlock = $factory->create($docComment); //this should be returned by getMethodsDocBlock($method)

        $this->docBlock = $docBlock;
    }

    public function validateAuthToken()
    {
        $requiresAuthArray = $this->docBlock->getTagsByName('Auth');

        if (!empty($requiresAuthArray)) {
            $authHeader = $this->container->getRequest()->getHeader('Authorization');

            $authenticator = new Authenticator($this->container->getEntityManager());

            return $authenticator->checkToken($authHeader);
        }
    }

    public function validateMethod(): bool
    {
        $allowedMethodsString = $this->docBlock->getTagsByName('Methods')[0]->getDescription()->getBodyTemplate();
        $allowedMethods = explode('|', $allowedMethodsString);

        $currentHttpMethod = $this->container->getRequest()->getMethod();

        if (!in_array($currentHttpMethod, $allowedMethods)) {
            throw new HttpMethodNotAllowedException($allowedMethods);
        }

        return true;
    }
}

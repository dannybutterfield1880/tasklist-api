<?php

namespace Core\Controller;

use Core\Entity\User;
use Core\Utils\Container;
use Monolog\Logger;
use Brick\Http\Request;
use Brick\Http\Response;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;


/**
 * Abstract controller containing common functionality
 *
 * Controller method naming convention excluding BaseController
 *
 * methodClassAction() i.e ... loginAuthAction() / loadUserAction() / updateTasklistAction()
 *
 */
abstract class BaseController extends \ReflectionClass {

    /**
     * @var Container $container
     */
    public $container;

    /**
     * BaseController constructor
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getJsonPostAsArray() : array {
        return json_decode($this->getRawPost(), true);
    }

    public function getRawPost() : string {
        return file_get_contents('php://input');
    }

    /**
     * @return EntityManager $entityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->container->getEntityManager();
    }

    /**
     * @return Response $response
     */
    public function getResponse(): Response
    {
        return $this->container->getResponse();
    }

    /**
     * @return Request $request
     */
    public function getRequest(): Request
    {
        return $this->container->getRequest();
    }

    /**
     * @return Serializer $serializer
     */
    public function getSerializer(): Serializer
    {
        return $this->container->getSerializer();
    }

    /**
     * @return Logger $logger
     */
    public function getLogger(): Logger
    {
        return $this->container->getLogger();
    }

    /**
     * @return ValidatorInterface $validator
     */
    public function getValidator() : ?ValidatorInterface
    {
        return $this->container->getValidator();
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->container->getUser();
    }
}

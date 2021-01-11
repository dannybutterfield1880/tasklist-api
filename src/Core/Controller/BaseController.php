<?php

namespace Core\Controller;

use Psr\Log\LoggerInterface;
use Brick\Http\Request;
use Brick\Http\Response;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;


/**
 * Abstract controller containing common functionality
 * 
 * Controller method naming convention excluding BaseController
 * 
 * methodClassAction() i.e ... loginAuthAction() / loadUserAction() / updateTasklistAction()
 */
abstract class BaseController {

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var Response $response
     */
    private $response;

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * @var Serializer $serializer
     */
    private $serializer;

    /**
     * BaseController constructor
     *
     * @param EntityManager $entityManager
     * @param Request $request
     * @param Response $response
     * @param Serializer $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(
        EntityManager $entityManager, 
        Request $request, 
        Response $response, 
        Serializer $serializer, 
        LoggerInterface $logger = null
    )
    {
        $this->entityManager = $entityManager;
        $this->request = $request->getCurrent();
        $this->response = $response;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * @return EntityManager $entityManager
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * @return Response $response
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @return Request $request
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @return Serializer $serializer
     */
    public function getSerializer() {
        return $this->serializer;
    }

    /**
     * @return LoggerInterface $logger
     */
    public function getLogger() {
        return $this->logger;
    }
}
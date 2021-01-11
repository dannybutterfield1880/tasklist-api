<?php

namespace Core\Controller;

use Brick\Http\Request;
use Brick\Http\Response;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * interface for basic controller implementation
 */
interface Controller {
    public function getEntityManager(EntityManager $entityManager);

    public function getResponse(Response $response);

    public function getRequest(Request $request);

    public function getLogger(LoggerInterface $logger);

    public function getSerializer(Serializer $serializer);
}
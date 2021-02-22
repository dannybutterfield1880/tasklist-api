<?php


namespace Core\Utils;


use Brick\Http\Request;
use Brick\Http\Response;
use Core\Entity\User;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Container
{
    /**
     * BaseController constructor
     *
     * @param EntityManager $entityManager
     * @param Request $request
     * @param Response $response
     * @param Serializer $serializer
     * @param ValidatorInterface|null $validator
     * @param Logger|null $logger
     */
    public function __construct(
        EntityManager $entityManager,
        Request $request,
        Response $response,
        Serializer $serializer,
        ValidatorInterface $validator = null,
        Logger $logger = null
    )
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
        $this->response = $response;
        $this->serializer = $serializer;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    /**
     * @return EntityManager $entityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return Response $response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return Request $request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Serializer $serializer
     */
    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    /**
     * @return Logger $logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }

    /**
     * @return ValidatorInterface $validator
     */
    public function getValidator() : ?ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var Response $response
     */
    protected $response;

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var Logger
     */
    protected $logger;


}

<?php


namespace Core\Utils;


use Core\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;

class Authenticator
{
    protected $entityManager;


    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * check token
     *
     * - only Bearer available at the moment
     *
     * @param $authHeader //jwt token
     * @return User
     * @throws Exception
     */
    public function checkToken($authHeader): User
    {
        $tokenType = substr(substr($authHeader, 0, 7), 0, 6);
        $token = substr($authHeader, 7);

        //TODO - move to Authenticator passing $tokenType and $token to __construct($tokenType, $token)
        //Authenticator will also need an instance of UserRepository

        //TODO - implement other token types
        if ($tokenType !== 'Bearer') echo 'please provide a bearer token';/*throw new \Exception('Please provide a Bearer token');*/

        $decodedToken = JWTEncoder::decode($token, 'task-lists');

        /** @var User $loggedInUser */
        $loggedInUser = $this->entityManager->getRepository(User::class)->find($decodedToken->uid);

        //does user in token exist
        if (!isset($loggedInUser)) {
            throw new Exception('User is not found!');
        }

        $dateTime = new DateTime('now');

        //has token expired
        if ($decodedToken->exp <= $dateTime->getTimestamp()) {
            throw new Exception('User\'s token has expired');
        }

        /**
         * token check
         *  - issuer is correct - was created by the right place
         *  - audience is correct - came from the right place
         */
        return $loggedInUser;
    }

}

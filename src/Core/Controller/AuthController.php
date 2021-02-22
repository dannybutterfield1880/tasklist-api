<?php

namespace Core\Controller;

use Core\Entity\User;
use Core\Utils\JWTEncoder;

/**
 * Authentication related method
 */
class AuthController extends BaseController
{
    /**
     * @Methods POST
     */
    function loginAuthAction() {
        $em = $this->getEntityManager();
        $repo = $em->getRepository(User::class);
        $post = $this->getJsonPostAsArray();
        /** @var User $user */
        $user = $repo->findOneBy([
            'username' => $post['username']
        ]);

        if (!isset($user)) {
            echo 'no user found';
            return;
        }

        if (!$user->verifyUsersPassword($post['password'])) {
            echo 'incorrect password provided';
        }

        $token = JWTEncoder::encode($user);

        echo $token;
    }

    /**
     * Register a new user
     *
     * @Methods POST
     */
    function registerAuthAction() {
        $em = $this->getEntityManager();

        try {
            /** @var User $user */
            $user = $this->getSerializer()->deserialize($this->getRawPost(), User::class, 'json');

        } catch (\Exception $exception) {
            dump($exception->getMessage());
            die();
        }

        dump($user);
        $this->getLogger()->info('New user registered');
        $errors = $this->getValidator()->validate($user);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;
            dump($errorsString);
            //return new Response($errorsString);
        }

        //do validation

        $tokenKey = password_hash($user->getUsername(), PASSWORD_DEFAULT);

        $user->setTokenKey($tokenKey);
        $user->setCreatedAt(new \DateTime());

        try {
            $em->persist($user);
            $em->flush();


            $token = JWTEncoder::encode($user, $tokenKey);
            dump($user);


            echo $token;
        } catch (\Exception $exception) {

            dump($exception);
        }
    }
}

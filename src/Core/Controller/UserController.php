<?php

namespace Core\Controller;

use Core\Entity\User;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * User related methods
 */
class UserController extends BaseController {
    public function loadUserAction($id): bool
    {
        $serializer = $this->getSerializer();

        try {
            $user = $this->getEntityManager()->getRepository(User::class)->find($id);

            if (!isset($user)) {
                throw new EntityNotFoundException('User not found!');
            }

            $data = $serializer->serialize($user, 'json');

            return $this->getResponse()
                ->withContent($data)
                ->withStatusCode(200)
                ->withHeader('Content-Type', 'application/json')
                ->send();
        } catch(EntityNotFoundException $ex) {
            $error = json_encode([
                'message' => $ex->getMessage()
            ]);
            return $this->getResponse()
                ->withContent($error)
                ->withStatusCode(404)
                ->send();
        }

    }
}

<?php

namespace Core\Controller;

use Core\Entity\User;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * User related methods
 */
class UserController extends BaseController {
    public function loadUserAction($id) {

        $user = $this->getEntityManager()->getRepository(User::class)->find($id);

        $data = $this->getSerializer()->serialize($user, 'json');
        
        return $this->getResponse()
                    ->withContent($data)
                    ->withStatusCode(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->send();
    }
}
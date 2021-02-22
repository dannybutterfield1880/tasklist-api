<?php

namespace Core\Controller;

use Core\Entity\Tasklist;
use Core\Entity\User;
use Doctrine\ORM\EntityNotFoundException;

/**
 * User related methods
 */
class UserController extends BaseController {

    /**
     * @param $id
     * @return bool
     * @Methods GET
     */
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

    /**
     * @param $id
     * @return bool
     * @Methods GET
     * @Auth
     */
    public function tasklistsUserAction() : bool
    {
        $serializer = $this->getSerializer();

        try {
            if (!$this->getUser()) {
                throw new EntityNotFoundException('You must be logged in to have task lists!');
            }

            $taskLists = $this->getEntityManager()->getRepository(Tasklist::class)->findBy([
                'creator' => $this->getUser()
            ]);

            $data = $serializer->normalize($taskLists, 'json', ['groups' => ['load_my_task_lists']]);

            $result = [
                'data' => $data,
                'totalCount' => count($taskLists)
            ];

            $response = $this->getResponse();
            return $response
                ->withStatusCode(200)
                ->withContent(json_encode($result))
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

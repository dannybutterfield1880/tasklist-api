<?php


namespace Core\Controller;


use Core\Entity\Task;
use Core\Entity\Tasklist;
use Core\Entity\User;
use Doctrine\ORM\ORMException;

class TaskController extends BaseController
{
    /**
     * /task-lists/new
     *
     * @Methods POST
     */
    public function newTaskAction()
    {
        $em = $this->getEntityManager();
        $serializer = $this->getSerializer();
        $postRaw = $this->getRawPost();
        $post = $this->getJsonPostAsArray();
        $creator = $this->getEntityManager()->getRepository(User::class)->find($post['creator']);

        try {
            /** @var Task $task */
            $task = $serializer->deserialize($postRaw, Task::class, 'json');

            $task->setCreator($creator);
            $task->setCreatedAt(new \DateTime());

            $em->persist($task);
            $em->flush();

            return $this->getResponse()
                ->withStatusCode(200)
                ->withHeader('Content-Type', 'application/json')
                ->withContent(json_encode([
                    'message' => 'Task created'
                ]))
                ->send();
        } catch (ORMException $exception) {
            dump($exception);
        }

    }

    /**
     * /task-lists/load/?id
     *
     * @Methods GET
     * @param null $id
     */
    public function loadTaskAction($id = null)
    {
        $repo = $this->getEntityManager()->getRepository(Task::class);

        if (!isset($id)) {
            $data = $repo->findAll();
        } else {
            $data = $repo->find($id);
        }

        $serialized = $this->getSerializer()->serialize($data, 'json');

        return $this->getResponse()
            ->withStatusCode(200)
            ->withHeader('Content-Type', 'application/json')
            ->withContent($serialized)
            ->send();
    }

    /**
     * @Auth
     * @Methods PATCH
     * @param $id
     */
    public function updateTaskAction($id): bool
    {
        $post = $this->getJsonPostAsArray();

        $em = $this->getEntityManager();
        /** @var Tasklist $taskList */
        $task = $em->getRepository(Task::class)->find($id);

        $task->setName($post['name']);
        $task->setUpdatedAt(new \DateTime('now'));

        try {
            $em->persist($task);
            $em->flush();

            return $this->getResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withStatusCode(200)
                ->withContent(json_encode([
                    'message' => 'Task updated'
                ]))
                ->send();
        } catch (ORMException $exception) {
            dump($exception);
        }
    }
}

<?php


namespace Core\Controller;


use Core\Entity\Task;
use Core\Entity\Tasklist;
use Core\Entity\User;
use Doctrine\ORM\ORMException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class TaskListController extends BaseController
{
    /**
     * /task-lists/new
     *
     * @Methods POST
     * @Auth
     */
    public function newTaskListAction()
    {
        $em = $this->getEntityManager();
        $serializer = $this->getSerializer();
        $postRaw = $this->getRawPost();
        $post = $this->getJsonPostAsArray();

        try {

            if (!$this->getUser()) {
                throw new \Exception('You must be logged in to create a task list');
            }

            $existing = $em->getRepository(Tasklist::class)->findOneBy([
                'name' => $post['name'],
                'creator' => $this->getUser()
            ]);

            if (isset($existing)) {
                throw new \Exception('you already have a task list with the same name');
            }

            /** @var Tasklist $taskList */
            $taskList = $serializer->deserialize($postRaw, Tasklist::class, 'json');

            $taskList->setCreator($this->getUser());
            $taskList->setCreatedAt(new \DateTime());

            $em->persist($taskList);
            $em->flush();

            return $this->getResponse()
                ->withStatusCode(200)
                ->withContent(json_encode([
                    'message' => 'Task list created'
                ]))
                ->send();
        } catch (ORMException $exception) {
            dump($exception);
        } catch (\Exception $exception) {
            $this->getResponse()
                ->withContent(json_encode([
                    'message' => "You already have a task list with this name"
                ]))
                ->withStatusCode(404)
                ->send();
        }

    }

    /**
     * /task-lists/load/?id
     *
     * @Methods GET
     * @param null $id
     */
    public function loadTaskListAction($id = null)
    {
        $repo = $this->getEntityManager()->getRepository(Tasklist::class);

        $taskList = $repo->find($id);


//        dump($results);
//        if (!isset($id)) {
//            $data = $repo->findAll();
//        } else {
//            $data = $repo->find($id);
//        }

        $serialized = $this->getSerializer()->serialize($taskList, 'json', ['groups' => ['load_single_task_list']]);

        return $this->getResponse()
            ->withStatusCode(200)
            ->withContent($serialized)
            ->send();
    }

    /**
     * @Auth
     * @Methods PATCH
     * @param $id
     */
    public function updateTaskListAction($id): bool
    {
        $post = $this->getJsonPostAsArray();

        $em = $this->getEntityManager();
        /** @var Tasklist $taskList */
        $taskList = $em->getRepository(Tasklist::class)->find($id);

        if ($taskList->getCreator() !== $this->getUser()) {
            echo 'this isn\'t your task list';
            die();
        }

        $taskList->setName($post['name']);
        $taskList->setUpdatedAt(new \DateTime('now'));

        try {
            $em->persist($taskList);
            $em->flush();

            return $this->getResponse()
                ->withHeader('Content-Type', 'application/json')
                ->withStatusCode(200)
                ->withContent(json_encode([
                    'message' => 'Task list updated'
                ]))
                ->send();
        } catch (ORMException $exception) {
            dump($exception);
        }
    }
}

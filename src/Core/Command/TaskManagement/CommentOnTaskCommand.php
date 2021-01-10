<?php

namespace Core\Command\TaskManagement;

use Core\Entity\Tasklist;
use Core\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class CommentOnTaskCommand extends Command
{
    protected static $defaultName = 'tasks:make-comment';
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Make a comment on a task and also have the change the priority, flagged and completed')
            ->setHelp('This command will add a comment to a task and give the creator a chance to update some attributes on the task')
            ->addArgument('creator', InputArgument::REQUIRED, 'Username of creator')
            ->addArgument('task', InputArgument::REQUIRED, 'id of the task to add a comment to')
            ->addArgument('message', InputArgument::REQUIRED, 'Message for the comment');

            // add a question asking if the user would like to create some
            // initial tasks straight away in the command
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $args = $input->getArguments();

        $creator = $this->entityManager->getRepository(\Core\Entity\User::class)->findOneBy([
            'username' => $args['creator']
        ]);

        //check if tasklist already exists with this name 
        $task = $this->entityManager->getRepository(\Core\Entity\Task::class)->find($args['task']);


        if ($task === null) {
            $io->error('the task you are trying to comment on doesn\'t exist');
            return Command::ERROR;
            exit;
        }

        $questionRows = [
            [
                'name' => 'priority',
                'text' => 'Do you want to change the priority of the task?',
                "options" => ['no', 'low', 'medium', 'high', 'urgent', 'there-is-a-fire']
            ],
            [
                'name' => 'flagged',
                'text' => 'Do you want to flag this task?',
                "options" => ['no', 'yes!']
            ],
            [
                "name" => 'completed',
                'text' => 'Have you completed this task?',
                "options" => ['no', 'yes!']
            ],
        ];

        $questionAnswers = [];
        $helper = $this->getHelper('question');

        foreach($questionRows as $questionRow) {
            $question = new ChoiceQuestion(
                $questionRow['text'],
                $questionRow['options'],
                0
            );

            if (in_array('no', $questionAnswers)) {
                exit;
            }

            $questionAnswers[$questionRow['name']] = $helper->ask($input, $output, $question);
        }

        $comment = new \Core\Entity\Comment();
        $comment
            ->setMessage($args['message'])
            ->setCreatedAt(new DateTime('now'));

        $task->addComment($comment); 

        foreach ($questionAnswers as $name => $questionAnswer) {
            if ($questionAnswer === 'no') {
                return;
            }
            $setter = sprintf('set%s', ucfirst($name));
            $task->$setter($questionAnswer);
        }

        $this->entityManager->persist($comment);
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        $io->success(sprintf('Comment %s made by %s on task %s', 
            $args['message'], 
            $creator->getUsername(),
            $args['task']
        ));

        return Command::SUCCESS;
    }
}
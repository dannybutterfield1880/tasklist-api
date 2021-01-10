<?php

namespace Core\Command\TasklistManagement;

use Core\Entity\Tasklist;
use Core\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddTaskToTasklistCommand extends Command
{
    protected static $defaultName = 'tasklists:add-task';
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Add a task to a tasklist')
            ->setHelp('This command will add a task to a task list')
            ->addArgument('creator', InputArgument::REQUIRED, 'Username of creator')
            ->addArgument('tasklist', InputArgument::REQUIRED, 'Name of task list to add to')
            ->addArgument('title', InputArgument::REQUIRED, 'Title for the task');

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
        $tasklist = $this->entityManager->getRepository(\Core\Entity\Tasklist::class)->findOneBy([
            'name' => $args['tasklist']
        ]);

        if ($tasklist === null) {
            $io->error(sprintf('tasklist %s doesn\'t exist', $args['tasklist']));
            return Command::ERROR;
            exit;
        }

        $helper = $this->getHelper('question');

        $question = new Question('<question>Do you want to give your task a description? press [enter] to skip</question>');

        $description = $helper->ask($input, $output, $question);

        $newTask = new \Core\Entity\Task();
        $newTask
            ->setTitle($args['title'])
            ->setCreator($creator)
            ->setTasklist($tasklist)
            ->setCreatedAt(new DateTime('now'));

        if (strlen($description) > 0) {
            $newTask->setDescription($description);
        }

        $this->entityManager->persist($newTask);
        $this->entityManager->flush();

        $io->success(sprintf('Task %s has been added to %s succefully by %s, %s a description.', 
            $args['title'], 
            $args['tasklist'], 
            $creator->getUsername(),
            ($newTask->getDescription !== null) ? 'with' : 'without' 
        ));

        return Command::SUCCESS;
    }
}
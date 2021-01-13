<?php

namespace Core\Command\TaskManagement;

use Core\Entity\Task;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class DeleteTaskCommand extends Command
{
    protected static $defaultName = 'tasks:delete';
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Delete a task')
            ->setHelp('This command will delete a task')
            ->addArgument('task', InputArgument::REQUIRED, 'id of task to delete');
            // add a question asking if the user would like to create some
            // initial tasks straight away in the command
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $args = $input->getArguments();

        $task = $this->entityManager->getRepository(Task::class)->find($args['task']);

        if (!isset($task)) {
            $io->error(sprintf('task %s doesn\'t exist', $args['task']));
            exit;
        }

        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion(
            '<question>Are you sure you want to delete this task?</question>',
            ['n', 'y']
        );

        $answer = $helper->ask($input, $output, $question);

        if ($answer === 'y') {
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        }

        $io->success(sprintf('Task %s has been deleted.',
            $args['task']
        ));

        return Command::SUCCESS;
    }
}

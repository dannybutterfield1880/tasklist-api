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

class ListTasklistsTasksCommand extends Command
{
    protected static $defaultName = 'tasklists:list-tasks';
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('List a tasklist tasks')
            ->setHelp('This command will show a list of tasks for a specific tasklist')
            ->addArgument('tasklist', InputArgument::REQUIRED, 'Name of task list to show')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Amount of tasks to show from the oldest first (optional)');

            // add a question asking if the user would like to create some
            // initial tasks straight away in the command
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $args = $input->getArguments();

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

        $tasklistRows = $this->entityManager
                        ->getRepository(\Core\Entity\Tasklist::class)
                        ->getTasklistsRowsForCommandLine($tasklist->getTasks());
    
        $io->table(
            ['done', $args['tasklist'], 'priority', 'flagged'],
            $tasklistRows
        );

        return Command::SUCCESS;
    }
}
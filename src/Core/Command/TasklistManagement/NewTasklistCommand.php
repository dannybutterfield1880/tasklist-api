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

class NewTasklistCommand extends Command
{
    protected static $defaultName = 'tasklists:create-tasklist';
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Create a new task list.')
            ->setHelp('This command will create a new task list')
            ->addArgument('creator', InputArgument::REQUIRED, 'Username of creator')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of task list');

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
            'name' => $args['name'],
            'creator' => $creator,
        ]);

        if ($tasklist !== null) {
            $io->error('You already have a tasklist with this name');
            exit;
        }

        $newTasklist = new Tasklist();
        $newTasklist
            ->setName($args['name'])
            ->setCreator($creator)
            ->setCreatedAt(new DateTime('now'));

        $this->entityManager->persist($newTasklist);
        $this->entityManager->flush();

        $io->success(sprintf('Tasklist %s created successfuly by %s', $args['name'], $creator->getUsername()));

        return Command::SUCCESS;
    }
}

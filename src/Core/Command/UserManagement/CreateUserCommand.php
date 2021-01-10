<?php

namespace Core\Command\UserManagement;

use Core\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Create new user command
 * 
 * um:create-user
 * 
 */
class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'users:create-user';
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Creates a new user.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a user...')
        ->addArgument('username', InputArgument::REQUIRED, 'Username')
        ->addArgument('password', InputArgument::REQUIRED, 'Password')
        ->addArgument('firstName', InputArgument::REQUIRED, 'First name')
        ->addArgument('lastName', InputArgument::REQUIRED, 'Last name')
        ->addArgument('email', InputArgument::REQUIRED, 'Email');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
         // outputs multiple lines to the console (adding "\n" at the end of each line)
         $output->writeln([
            '<info>User Creator</info>',
            '<comment>============</comment>',
            '',
        ]);
        $helper = $this->getHelper('question');

        $question = new Question('<question>Enter password</question>');
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        $password = $helper->ask($input, $output, $question);

        dump($this->entityManager);
        $args = $input->getArguments();

        $user = new User();
        $user
            ->setUsername($args["username"])
            ->setFirstName($args['firstName'])
            ->setLastName($args['lastName'])
            ->setEmail($args['email'])
            ->setPassword(User::hashPassword($password))
            ->setCreatedAt(new DateTime('now'));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword
        //$output->writeln($this->someMethod());

        // outputs a message without adding a "\n" at the end of the line
        $output->write('user created.');

        return Command::SUCCESS;
    }
}
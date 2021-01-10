<?php

namespace Core\Command\Auth;

use Core\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class LoginCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'auth:login';
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
            ->setDescription('Login a user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command logs in a user and returns a valid auth token...')
            ->addArgument('username', InputArgument::REQUIRED, 'Username');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        
        $helper = $this->getHelper('question');

        $question = new Question('<question>Enter password</question>');
        $question->setHidden(true);
        $question->setHiddenFallback(false);

        $password = $helper->ask($input, $output, $question);

        $args = $input->getArguments();

        //first look for user
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $args['username']]);

        if ($user === null) {
            //user not found
            $io->error('No user found!');
            exit;
        }

        // Print the result depending if they match 
        if ($user->verifyUsersPassword($password)) { 
            $io->success("Password verified! Login complete! token not implemented yet");
        } else { 
            $io->error("Password incorrect! Access denied!");
        } 

        return Command::SUCCESS;
    }
}
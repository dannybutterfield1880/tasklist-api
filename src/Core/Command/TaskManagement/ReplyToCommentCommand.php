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

class ReplyToCommentCommand extends Command
{
    protected static $defaultName = 'tasks:reply-to-comment';
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Reply to a comment and also have the option to like the comment')
            ->setHelp('This command will reply to a comment and also give the creator the option of liking the comment')
            ->addArgument('creator', InputArgument::REQUIRED, 'Username of creator')
            ->addArgument('comment', InputArgument::REQUIRED, 'id of the task to add a comment to')
            ->addArgument('message', InputArgument::REQUIRED, 'Message for the reply');

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
        $comment = $this->entityManager->getRepository(\Core\Entity\Comment::class)->find($args['comment']);


        if ($comment === null) {
            $io->error('the comment you are trying to reply to doesn\'t exist');
            exit;
        }

        $question = new ChoiceQuestion(
            "Would you like to like the comment to?",
            ['n', 'y'],
            0
        );

        $helper = $this->getHelper('question');

        $answer = $helper->ask($input, $output, $question);

        $reply = new \Core\Entity\Comment();
        $reply
            ->setMessage($args['message'])
            ->setCreator($creator)
            ->setReplyRespondant($comment)
            ->setCreatedAt(new DateTime('now'));
    
        if ($answer === 'y') {
            //$comment->addComment($comment); 
        }

        $this->entityManager->persist($reply);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        $io->success(sprintf('Reply %s made by %s on comment %s', 
            $args['message'], 
            $creator->getUsername(),
            $args['comment']
        ));

        return Command::SUCCESS;
    }
}
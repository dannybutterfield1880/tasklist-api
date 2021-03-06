#!/usr/bin/env php
<?php

use Composer\Autoload\ClassLoader;
use Symfony\Component\Console\Application;
use Doctrine\Common\Annotations\AnnotationRegistry;

use Core\Command\TaskManagement\DeleteTaskCommand;
use Core\Command\UserManagement\CreateUserCommand;
use Core\Command\Auth\LoginCommand;
use Core\Command\TasklistManagement\NewTasklistCommand;
use Core\Command\TasklistManagement\AddTaskToTasklistCommand;
use Core\Command\TasklistManagement\ListTasklistsTasksCommand;
use Core\Command\TaskManagement\CommentOnTaskCommand;
use Core\Command\TaskManagement\ReplyToCommentCommand;

/**
 * @var ClassLoader $loader
 */
$loader = require_once __DIR__.'/../vendor/autoload.php';
require __DIR__."/../helpers.php";

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

// obtaining the entity manager
$entityManager = makeEntityManager();

$application = new Application();

/**
 * user management commands
 *
 * users:
 */
$application->add(new CreateUserCommand($entityManager));

/**
 * authentication commands
 *
 * auth:
 */
$application->add(new LoginCommand($entityManager));

/**
 * task lists management commands
 *
 * tasklists:
 */
$application->add(new NewTasklistCommand($entityManager));
$application->add(new AddTaskToTasklistCommand($entityManager));
$application->add(new ListTasklistsTasksCommand($entityManager));

/**
 * tasks management commands
 *
 * tasks:
 */
$application->add(new CommentOnTaskCommand($entityManager));
$application->add(new ReplyToCommentCommand($entityManager));
$application->add(new DeleteTaskCommand($entityManager));

try {
    $application->run();
} catch (Exception $e) {
    dump($e);
}

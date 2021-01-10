#!/usr/bin/env php

<?php
// application.php

require __DIR__.'/../vendor/autoload.php';
include __DIR__."/../helpers.php";

use Core\Command\UserManagement\CreateUserCommand;

use Core\Command\Auth\LoginCommand;
use Core\Command\TasklistManagement\NewTasklistCommand;
use Core\Command\TasklistManagement\AddTaskToTasklistCommand;
use Core\Command\TasklistManagement\ListTasklistsTasksCommand;

use Core\Command\TaskManagement\CommentOnTaskCommand;

use Symfony\Component\Console\Application;


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

$application->run();
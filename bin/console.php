#!/usr/bin/env php

<?php
// application.php

require __DIR__.'/../vendor/autoload.php';
include __DIR__."/../helpers.php";

use Core\Command\CreateUserCommand;
use Core\Command\LoginCommand;
use Symfony\Component\Console\Application;


// obtaining the entity manager
$entityManager = makeEntityManager();

$application = new Application();

// ... register commands
$application->add(new CreateUserCommand($entityManager));
$application->add(new LoginCommand($entityManager));

$application->run();
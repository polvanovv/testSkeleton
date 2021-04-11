<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = include __DIR__."/container.php";
$entityManager = $container->get('entity_manager');

return ConsoleRunner::createHelperSet($entityManager);
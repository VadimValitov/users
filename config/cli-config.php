<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Build container
$serviceManager = require __DIR__ . '/container.php';
$entityManager = $serviceManager->get(EntityManager::class);

return ConsoleRunner::createHelperSet($entityManager);

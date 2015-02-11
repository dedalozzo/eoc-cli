#! /usr/bin/php
<?php

/**
 * @file couch.php
 * @brief CouchDB Command-Line Client.
 * @details
 * @author Filippo F. Fadda
 */

error_reporting (E_ALL & ~(E_NOTICE | E_STRICT));

$loader = require_once __DIR__ . "/../vendor/autoload.php";


use ElephantOnCouch\Console\Console;
use ElephantOnCouch\Console\Command;
use ElephantOnCouch\Console\Version;

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;


$start = microtime(true);

try {
  $root = realpath(__DIR__."/../");

  // Initializes the Composer autoloading system. (Note: We don't use the Phalcon loader.)
  require $root."/vendor/autoload.php";

  $monolog = new Logger('couch');

  // Registers the Monolog error handler to log errors and exceptions.
  ErrorHandler::register($monolog);

  // Creates a stream handler to log debugging messages.
  $monolog->pushHandler(new StreamHandler($root.$config->application->logDir."pit.log", Logger::DEBUG));

  // Creates the application object.
  $console = new Console('PitPress Console', Version::getNumber());
  $console->setCatchExceptions(FALSE);

  $console->add(new Command\AboutCommand());
  $console->add(new Command\UseCommand());
  $console->add(new Command\CleanupCommand());
  $console->add(new Command\CommitCommand());
  $console->add(new Command\CompactCommand());
  $console->add(new Command\CreateCommand());
  $console->add(new Command\DeleteCommand());
  $console->add(new Command\QueryCommand());
  $console->add(new Command\StatusCommand());

  //  $console->add(new Command\RestartServerCommand());
  //  $console->add(new Command\ServerInfoCommand());
  //  $console->add(new Command\ClientInfoCommand());
  //  $console->add(new Command\Stats());
  //  $console->add(new Command\AllDbs());
  //  $console->add(new Command\DbUpdates());
  //  $console->add(new Command\ActiveTasks());
  //  $console->add(new Command\LogTail());
  //  $console->add(new Command\Uuids());
  //  $console->add(new Command\getConfig());
  //  $console->add(new Command\setKey());
  //  $console->add(new Command\deleteKey());
  //  $console->add(new Command\SelectDbCommand());
  //  $console->add(new Command\CreateDbCommand());
  //  $console->add(new Command\DeleteDbCommand());
  //  $console->add(new Command\DbInfoCommand());
  //  $console->add(new Command\DbChangesCommand());
  //  $console->add(new Command\CompactDbCommand());
  //  $console->add(new Command\CompactViewCommand());
  //  $console->add(new Command\StartReplicationCommand());
  //  $console->add(new Command\StopReplicationCommand());

  $console->run();
}
catch (Exception $e) {
  echo $e;
}
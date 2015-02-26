#! /usr/bin/php
<?php

/**
 * @file couch.php
 * @brief CouchDB Command-Line Client.
 * @details
 * @author Filippo F. Fadda
 */


if (PHP_SAPI !== 'cli')
  echo 'Warning: EoC CLI should be invoked via the CLI version of PHP, not the '.PHP_SAPI.' SAPI.';


error_reporting(E_ALL & ~(E_NOTICE | E_STRICT));

$loader = require_once __DIR__ . "/../vendor/autoload.php";


use EoC\CLI\Console;
use EoC\CLI\Command;
use EoC\CLI\Version;

use Monolog\Logger;
use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;


$start = microtime(true);

try {
  $root = realpath(__DIR__."/../");

  // Initializes the Composer autoloading system. (Note: We don't use the Phalcon loader.)
  require $root."/vendor/autoload.php";

  $log = new Logger('couch');

  // Registers the Monolog error handler to log errors and exceptions.
  ErrorHandler::register($log);

  // Creates a stream handler to log debugging messages.
  $log->pushHandler(new StreamHandler($root.'/log/couch.log', Logger::DEBUG));

  // Creates the application object.
  $console = new Console('EoC CLI', Version::getNumber());
  //$console->setCatchExceptions(FALSE);

  $console->add(new Command\ConnectCommand());
  $console->add(new Command\VersionCommand());
  $console->add(new Command\StatusCommand());
  $console->add(new Command\RestartCommand());
  $console->add(new Command\UseCommand());
  $console->add(new Command\InfoCommand());
  $console->add(new Command\CommitCommand());
  $console->add(new Command\CompactCommand());
  $console->add(new Command\CleanupCommand());
  $console->add(new Command\CreateCommand());
  $console->add(new Command\DeleteCommand());
  $console->add(new Command\QueryCommand());
  $console->add(new Command\RestartCommand());
  $console->add(new Command\LogCommand());
  $console->add(new Command\UuidsCommand());
  //  $console->add(new Command\Stats());
  //  $console->add(new Command\AllDbs());
  //  $console->add(new Command\DbUpdates());
  //  $console->add(new Command\getConfig());
  //  $console->add(new Command\setKey());
  //  $console->add(new Command\deleteKey());
  //  $console->add(new Command\DbChangesCommand());
  //  $console->add(new Command\StartReplicationCommand());
  //  $console->add(new Command\StopReplicationCommand());
  //  $console->add(new Command\MissingRevsCommand());
  //  $console->add(new Command\RevsDiffCommand());
  //  $console->add(new Command\SetRevsLimitCommand());
  //  $console->add(new Command\GetDocETagCommand());
  //  $console->add(new Command\GetDoc());
  //  $console->add(new Command\PutDoc());
  //  $console->add(new Command\DeleteDoc());
  //  $console->add(new Command\CopyDoc());
  //  $console->add(new Command\PurgeCommand());
  //  $console->add(new Command\BulkCommand());
  //  $console->add(new Command\GetAttachmentInfo());
  //  $console->add(new Command\PutAttachment());
  //  $console->add(new Command\DeleteAttachment());
  //  $console->add(new Command\GetDesignDocInfo());

  $console->run();
}
catch (Exception $e) {
  echo $e;
}
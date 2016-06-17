<?php

/**
 * @file ConnectCommand.php
 * @brief This file contains the ConnectCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

use EoC\Couch;
use EoC\Adapter;


/**
 * @brief Connects to CouchDB server..
 * @nosubgrouping
 * @todo Fix a bug when read map and reduce from file.
 */
class ConnectCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("connect");
    $this->setDescription("Connects to CouchDB server");

    $this->addArgument("user",
      InputArgument::REQUIRED,
      "The CouchDB user name to use when connecting to the server");

    $this->addOption("server",
      "s",
      InputOption::VALUE_OPTIONAL,
      <<<'DESC'
Connects to the CouchDB server on the given host
Server must be expressed as host:port according to RFC 3986.
DESC
      ,
      Adapter\AbstractAdapter::DEFAULT_SERVER);
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $user = (string)$input->getArgument('user');

    $question = new Question('Enter password:');
    $question->setHidden(true);
    $question->setHiddenFallback(false);

    $helper = $this->getHelper('question');
    $password = $helper->ask($input, $output, $question);

    $server = (string)$input->getOption('server');

    $couch = new Couch(new Adapter\CurlAdapter($server, $user, $password));
    $couch->getServerInfo(); // Checks the connection.

    $connection = [];
    $connection['server'] = $server;
    $connection['user'] = $user;
    $connection['password'] = $password;

    $serialized = serialize($connection);

    // We reset the database in use.
    if ($shmKey = ftok($_SERVER['PHP_SELF'], 'd')) {
      if (@$shmId = shmop_open($shmKey, "a", 0644, 0))
        shmop_delete($shmId);
    }

    if ($shmKey = ftok($_SERVER['PHP_SELF'], 'c')) {

      if (@$shmId = shmop_open($shmKey, 'a', 0644, 0))
        shmop_delete($shmId);

      $shmId = shmop_open($shmKey, 'n', 0644, mb_strlen($serialized));

      if ($shmId) {
        $shmBytesWritten = shmop_write($shmId, $serialized, 0);
        shmop_close($shmId);
      }
      else
        throw new \RuntimeException("Couldn't create shared memory segment.");
    }
    else
      throw new \RuntimeException("Cannot get a System V IPC key.");
  }

}
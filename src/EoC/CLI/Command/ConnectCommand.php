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
    $this->setDescription("Connects to CouchDB server.");

    $this->addArgument("user",
      InputArgument::REQUIRED,
      "The CouchDB user name to use when connecting to the server.");

    $this->addOption("server",
      "s",
      InputOption::VALUE_OPTIONAL,
      "Connects to the CouchDB server on the given host. Server must be expressed as host:port according to RFC 3986.",
      Adapter\AbstractAdapter::DEFAULT_SERVER);
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $user = (string)$input->getArgument('user');

    $dialog = $this->getHelper('dialog');
    $password = $dialog->askHiddenResponse(
      $output,
      'Enter password:',
      FALSE
    );

    $server = (string)$input->getOption('server');

    $couch = new Couch(new Adapter\CurlAdapter($host, $user, $password));
    $couch->getServerInfo(); // Checks the connection.

    $connection = [];
    $connection['server'] = $server;
    $connection['user'] = $user;
    $connection['password'] = $password;

    $serialized = serialize($connection);

    $shmKey = ftok(__FILE__, 'connection');
    $shmId = shmop_open($shmKey, "c", 0644, mb_strlen($serialized));

    if ($shmId) {
      $shmBytesWritten = shmop_write($shmId, $serialized, 0);
      shmop_close($shmId);
    }
    else
      throw new \RuntimeException("Couldn't create shared memory segment.");
  }

}
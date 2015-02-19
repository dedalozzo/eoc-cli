<?php

/**
 * @file ConnectCommand.php
 * @brief This file contains the ConnectCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace ElephantOnCouch\Console\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use ElephantOnCouch\Couch;
use ElephantOnCouch\Adapter;
use ElephantOnCouch\Opt\ViewQueryOpts;


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

    $this->addOption("host",
      "t",
      InputOption::VALUE_REQUIRED,
      "Connects to the CouchDB server on the given host.");
  }


  /**
   * @brief Executes the command.
   * @bug https://github.com/dedalozzo/pit-press/issues/1
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $user = (string)$input->getArgument('user');

    $dialog = $this->getHelper('dialog');
    $password = $dialog->askHiddenResponse(
      $output,
      'Enter password:',
      FALSE
    );

    $host = (string)$input->getOption('host');

    $couch = new Couch(new Adapter\CurlAdapter($host, $user, $password));
    $couch->getServerInfo(); // Checks the connection.

    $connection = [];
    $connection['host'] = $host;
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
      die ("Couldn't create shared memory segment\n");
  }

}
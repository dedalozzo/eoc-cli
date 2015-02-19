<?php

/**
 * @file RestartCommand.php
 * @brief This file contains the RestartCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace ElephantOnCouch\Console\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief Displays CouchDB server and client versions.
 * @nosubgrouping
 */
class VersionCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("about");
    $this->setDescription("Displays CouchDB server and client versions.");
  }


  /**
   * @brief Executes the command.
   * @param[in] InputInterface $input The input interface
   * @param[in] OutputInterface $output The output interface
   * @return string Information about CouchDB's client, server and the PitPress database.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $couch = $this->di['couchdb'];

    echo "[server]".PHP_EOL;
    echo $couch->getServerInfo();
    echo PHP_EOL;
    echo "[client]".PHP_EOL;
    echo $couch->getClientInfo();
  }

}
<?php

/**
 * @file RestartCommand.php
 * @brief This file contains the RestartCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief Restarts CouchDB.
 * @nosubgrouping
 */
class RestartCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("restart");
    $this->setDescription("Restarts CouchDB server.");
  }


  /**
   * @brief Executes the command.
   * @param[in] InputInterface $input The input interface
   * @param[in] OutputInterface $output The output interface
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $couch = $this->getConnection();
    $couch->restartServer();
  }

}
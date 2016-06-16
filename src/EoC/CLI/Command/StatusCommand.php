<?php

/**
 * @file StatusCommand.php
 * @brief This file contains the StatusCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief Gets PitPress list of active tasks.
 * @nosubgrouping
 */
class StatusCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("status");
    $this->setDescription("Gets the list of active tasks");
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $couch = $this->getConnection();
    print_r($couch->getActiveTasks());
  }

}
<?php

/**
 * @file UseCommand.php
 * @brief This file contains the UseCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use EoC\Couch;
use EoC\Adapter\NativeAdapter;


/**
 * @brief Selects the specified database.
 * @nosubgrouping
 */
class UseCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("use");
    $this->setDescription("Deletes the PitPress database.");
    $this->setAliases(['select, connect']);
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $config = $this->di['config'];





    parent::execute($input, $output);
  }

}
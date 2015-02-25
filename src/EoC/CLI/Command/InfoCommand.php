<?php

/**
 * @file InfoCommand.php
 * @brief This file contains the InfoCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief Displays information about the selected database.
 * @nosubgrouping
 */
class InfoCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("info");
    $this->setDescription("Displays information about the selected database.");
  }


  /**
   * @brief Executes the command.
   * @param[in] InputInterface $input The input interface
   * @param[in] OutputInterface $output The output interface
   * @return string Information about current database.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $couch = $this->getConnection();

    echo "[database]".PHP_EOL;
    echo $couch->getDbInfo();
  }

}
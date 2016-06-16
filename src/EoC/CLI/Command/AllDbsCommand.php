<?php

/**
 * @file AllDbsCommand.php
 * @brief This file contains the AllDbsCommand class.
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
class AllDbsCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("alldbs");
    $this->setDescription("Returns a list of all databases on this server");
  }


  /**
   * @brief Executes the command.
   * @param[in] InputInterface $input The input interface
   * @param[in] OutputInterface $output The output interface
   * @retval string Information about current database.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $couch = $this->getConnection();

    $dbs = $couch->getAllDbs();
    foreach ($dbs as $db)
      echo $db.PHP_EOL;
  }

}
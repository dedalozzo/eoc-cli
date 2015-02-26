<?php

/**
 * @file CompactCommand.php
 * @brief This file contains the CompactCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief Starts a compaction for the current selected database.
 * @nosubgrouping
 */
class CompactCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("compact");
    $this->setDescription("Starts a compaction for the current selected database or just a set of views.");

    $this->addOption("design-doc",
      NULL,
      InputOption::VALUE_REQUIRED,
      "Name of the design document where are stored the views to compact.");
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $couch = $this->getConnection();
    $couch->selectDb($this->getDatabase());

    if ($designDoc = $input->getOption('design-doc'))
      $couch->compactView($designDoc);
    else
      $couch->compactDb();
  }

}
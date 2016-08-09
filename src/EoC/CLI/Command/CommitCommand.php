<?php

/**
 * @file CommitCommand.php
 * @brief This file contains the CommitCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use EoC\Helper\TimeHelper;


/**
 * @brief Makes sure all uncommited database changes are written and synchronized to the disk.
 * @nosubgrouping
 */
class CommitCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("commit");
    $this->setDescription("Makes sure all uncommited database changes are written and synchronized to the disk");
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $couch = $this->getConnection();

    $time = TimeHelper::since($couch->ensureFullCommit($this->getDatabase()), TRUE);

    $output->writeln(sprintf('File opened since: %d days, %d hours, %d minutes, %d seconds', $time['days'], $time['hours'], $time['minutes'], $time['seconds']));
  }

}
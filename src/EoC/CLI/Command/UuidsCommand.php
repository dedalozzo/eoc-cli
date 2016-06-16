<?php

/**
 * @file UuidsCommand.php
 * @brief This file contains the UuidsCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief Returns a list of generated UUIDs.
 * @nosubgrouping
 */
class UuidsCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("uuids");
    $this->setDescription("Returns a list of generated UUIDs");

    // General options.
    $this->addOption("count",
      NULL,
      InputOption::VALUE_OPTIONAL,
      "Requested UUIDs number.",
      1);
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $count = (int)$input->getOption('count');

    $couch = $this->getConnection();
    $output->writeln($couch->getUuids($count));
  }

}
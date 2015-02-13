<?php

/**
 * @file LogCommand.php
 * @brief This file contains the LogCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace ElephantOnCouch\Console\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief Returns the tail of the server's log file.
 * @nosubgrouping
 */
class LogCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("uuids");
    $this->setDescription("Returns a list of generated UUIDs.");

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
    $this->couch->getUuids($count);

    parent::execute($input, $output);
  }

}
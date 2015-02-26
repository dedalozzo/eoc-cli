<?php

/**
 * @file LogCommand.php
 * @brief This file contains the LogCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


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
    $this->setName("log");
    $this->setDescription("Returns the tail of the server's log file.");

    // General options.
    $this->addOption("bytes",
      NULL,
      InputOption::VALUE_OPTIONAL,
      "How many bytes to return from the end of the log file.",
      1000);
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $bytes = (int)$input->getOption('bytes');

    $couch = $this->getConnection();
    $couch->getLogTail($bytes);
  }

}
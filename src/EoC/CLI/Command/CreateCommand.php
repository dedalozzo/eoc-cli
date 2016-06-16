<?php

/*
 * @file CreateCommand.php
 * @brief This file contains the CreateCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief Creates a new PitPress database.
 * @nosubgrouping
 */
class CreateCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("create");
    $this->setDescription("Creates a new database");

    $this->addArgument("database",
      InputArgument::REQUIRED,
      "The CouchDB database name to use.");
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $database = (string)$input->getArgument('database');

    $couch = $this->getConnection();

    $couch->createDb($database);
  }

}
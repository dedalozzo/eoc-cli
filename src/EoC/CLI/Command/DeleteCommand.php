<?php

/**
 * @file DeleteCommand.php
 * @brief This file contains the DeleteCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;


/**
 * @brief Deletes the PitPress database.
 * @nosubgrouping
 */
class DeleteCommand extends AbstractCommand {


  /**
   * @brief Configures the command.
   */
  protected function configure() {
    $this->setName("delete");
    $this->setDescription("Deletes the specified database, if not in use");

    $this->addArgument("database",
      InputArgument::REQUIRED,
      "The CouchDB database name to delete");
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $database = (string)$input->getArgument('database');

    $couch = $this->getConnection();

    // In case there is a database in use, we select it, because you the selected database can't be deleted.
    if ($database === $this->getDatabase())
      throw new \RuntimeException('You cannot delete the selected database.');

    $question = new ConfirmationQuestion('Are you sure you want delete the database? [Y/n]', FALSE);

    $helper = $this->getHelper('question');

    if ($helper->ask($input, $output, $question))
      $couch->deleteDb($database);
  }

}
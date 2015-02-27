<?php

/**
 * @file UseCommand.php
 * @brief This file contains the UseCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace EoC\CLI\Command;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


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
    $this->setDescription("Uses the specified database.");
    $this->setAliases(['select']);

    $this->addArgument("database",
      InputArgument::REQUIRED,
      "The CouchDB database name to use.");
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $database = (string)$input->getArgument('database');

    if ($shmKey = ftok($_SERVER['PHP_SELF'], 'd')) {

      if (@$shmId = shmop_open($shmKey, "a", 0644, 0))
        shmop_delete($shmId);

      $shmId = shmop_open($shmKey, 'n', 0644, mb_strlen($database));

      if ($shmId) {
        $shmBytesWritten = shmop_write($shmId, $database, 0);
        shmop_close($shmId);
      }
      else
        throw new \RuntimeException("Couldn't create shared memory segment.");
    }
    else
      throw new \RuntimeException("Cannot get a System V IPC key.");
  }

}
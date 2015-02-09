<?php

/**
 * @file DeleteCommand.php
 * @brief This file contains the DeleteCommand class.
 * @details
 * @author Filippo F. Fadda
 */


namespace ElephantOnCouch\Console\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use ElephantOnCouch\Couch;
use ElephantOnCouch\Adapter\NativeAdapter;


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
    $this->setDescription("Deletes the PitPress database.");
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $dialog = $this->getHelperSet()->get('dialog');
    $confirm = $dialog->ask($output, 'Are you sure you want delete the database? [Y/n]'.PHP_EOL, 'n');

    if ($confirm == 'Y') {
      $config = $this->di['config'];

      $couch = new Couch(new NativeAdapter(NativeAdapter::DEFAULT_SERVER, $config->couchdb->user, $config->couchdb->password));

      $couch->deleteDb($config->couchdb->database);

      $redis = $this->di['redis'];
      $redis->flushDB();

      parent::execute($input, $output);
    }
  }

}
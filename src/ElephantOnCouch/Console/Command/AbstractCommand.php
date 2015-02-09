<?php

/**
 * @file AbstractCommand.php
 * @brief This file contains the AbstractCommand class.
 * @details
 * @author Filippo F. Fadda
 */


//! This is the Commands namespace.
namespace ElephantOnCouch\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use ElephantOnCouch\Helper\TimeHelper;


/**
 * @brief This class represents an abstract command that implements the InjectionAwareInterface to automatic set the
 * Phalcon Dependency Injector and make it available to every subclasses.
 * @nosubgrouping
 */
abstract class AbstractCommand extends Command {

  protected $di;
  protected $monolog;

  protected $start;


  /**
   * @brief Creates an instance of the command.
   */
  public function __construct() {
    parent::__construct();

    $this->start = time();
  }


  /**
   * @brief Returns `true` in case `$arg` seems to be the string representation of an array, `false` otherwise.
   * @param[in] $arg The command line argument.
   */
  protected function isArray($arg) {
    if (preg_match('/\A[\[]([^\[\]]+)[\]]\z/i', $arg, $matches))
      return TRUE;
    else
      return FALSE;
  }


  /**
   * @brief Returns `true` in case `$arg` is enclosed between paired delimiters ('' or ""), `false` otherwise.
   * @details In case the argument is a string, paired delimiters are removed.
   * @param[in|out] $arg The command line argument.
   */
  protected function isString(&$arg) {
    if (preg_match('/\A[\'"]([^\'"]+)[\'"]\z/i', $arg, $matches)) {
      $arg = $matches[1];
      return TRUE;
    }
    else
      return FALSE;
  }


  /**
   * @brief Casts the argument to the right format and jsonify it when necessary.
   * @param[in] $arg The command line argument.
   * @param[in] boolean $encode (optional) JSON encodes `$arg`.
   */
  protected function castArg($arg, $encode = TRUE) {
    if ($this->isArray($arg))
      return $arg;
    elseif ($this->isString($arg)) {
      if ($encode)
        return json_encode($arg);
      else
        return $arg;
    }
    else
      return $arg + 0;
  }


  /**
   * @brief Executes the command.
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $time = TimeHelper::since($this->start);
    $output->writeln(PHP_EOL.sprintf("%d days, %d hours, %d minutes, %d seconds", $time['days'], $time['hours'], $time['minutes'], $time['seconds']));
  }


  /**
   * @brief Overrides this method to set the Dependency Injector.
   */
  public function setApplication(Application $application = null) {
    parent::setApplication($application);

    if ($application)
      $this->setDi($application->getDi());
  }

}
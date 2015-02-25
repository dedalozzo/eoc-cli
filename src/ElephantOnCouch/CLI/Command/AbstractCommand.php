<?php

/**
 * @file AbstractCommand.php
 * @brief This file contains the AbstractCommand class.
 * @details
 * @author Filippo F. Fadda
 */


//! This is the Commands namespace.
namespace ElephantOnCouch\CLI\Command;


use ElephantOnCouch\Adapter\AbstractAdapter;
use ElephantOnCouch\Adapter\CurlAdapter;
use ElephantOnCouch\Couch;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @brief This class represents an abstract command that implements the InjectionAwareInterface to automatic set the
 * Phalcon Dependency Injector and make it available to every subclasses.
 * @nosubgrouping
 */
abstract class AbstractCommand extends Command {

  /**
   * @brief Creates an instance of the command.
   */
  public function __construct() {
    parent::__construct();
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


  protected function getConnection() {
    $shmKey = ftok(__FILE__, 'connection');

    $shmId = shmop_open($shmKey, "c", 0644, 0);
    if ($shmId) {
      // Gets shared memory block's size.
      $shmSize = shmop_size($shmId);

      // Now lets read the memory segment.
      if ($buffer = shmop_read($shmId, 0, $shmSize)) {
        $serialized = substr($buffer, 0, strpos($buffer, "\0"));
        $connection = unserialize($serialized);
      }
      else
        throw new \RuntimeException("You are not connected to the server.");

      shmop_close($shmId);
    }
    else
      throw new \RuntimeException("You are not connected to the server.");


    return new Couch(new CurlAdapter($connection['server'], $connection['user'], $connection['password']));
  }


  protected function getDatabase() {

  }

}
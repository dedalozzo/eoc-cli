<?php

/**
 * @file AbstractCommand.php
 * @brief This file contains the AbstractCommand class.
 * @details
 * @author Filippo F. Fadda
 */


//! This is the Commands namespace.
namespace EoC\CLI\Command;


use EoC\Adapter\CurlAdapter;
use EoC\Couch;

use Symfony\Component\Console\Command\Command;


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
   * @param[in] mixed $arg The command line argument.
   * @return bool
   */
  protected function isArray($arg) {
    if (preg_match('/\A[\[]([^\[\]]+)[\]]\z/i', $arg, $matches))
      return TRUE;
    else
      return FALSE;
  }


  /**
   * @brief Returns `true` in case `$arg` is a formatted argument, `false` otherwise.
   * @details The argument type can be specified using the syntax \%s/. The final slash is followed by the value.\n
   *     \%s - the argument is treated as a string.\n
   *     \%b - the argument is treated as a boolean.\n
   *     \%i - the argument is treated as an integer.\n
   *     \%f - the argument is treated as a float.
   * @param[in,out] mixed $arg The command line argument.
   * @return bool
   */
  protected function isFormatted(&$arg) {
    //  \A            # Assert position at the beginning of the string
    //  (?P<type>     # Match the regular expression below and capture its match into backreference with name “type”
    //                  # Match either the regular expression below (attempting the next alternative only if this one fails)
    //        %s          # Match the characters “%s” literally
    //     |            # Or match regular expression number 2 below (attempting the next alternative only if this one fails)
    //        %b          # Match the characters “%b” literally
    //     |            # Or match regular expression number 3 below (attempting the next alternative only if this one fails)
    //        %i          # Match the characters “%i” literally
    //     |            # Or match regular expression number 4 below (the entire group fails if this one fails to match)
    //        %f          # Match the characters “%f” literally
    //  )
    //  /             # Match the character “/” literally
    //  (?P<value>    # Match the regular expression below and capture its match into backreference with name “value”
    //        .         # Match any single character that is not a line break character
    //          +         # Between one and unlimited times, as many times as possible, giving back as needed (greedy)
    //  )
    //  \z            # Assert position at the very end of the string
    if (preg_match('#\A(?P<type>%s|%b|%i|%f)/(?P<value>.+)\z#i', $arg, $matches)) {
      $type = $matches['type'];
      $value = $matches['value'];

      switch ($type) {
        case '%s':
          $arg = (string)$value;
          break;
        case '%b':
          $arg = (strtolower($value) === 'false') ? FALSE : (bool)$value;
          break;
        case '%i':
          $arg = (integer)$value;
          break;
        case '%f':
          $arg = (float)$value;
          break;
      }

      return TRUE;
    }
    else {
      return FALSE;
    }
  }


  /**
   * @brief Casts the argument to the right format and jsonify it when necessary.
   * @param[in] mixed $arg The command line argument.
   * @param[in] bool $encode (optional) JSON encodes `$arg`.
   * @return mixed
   */
  protected function castArg($arg, $encode = TRUE) {
    echo "Original argument: ".$arg.PHP_EOL;
    if ($this->isArray($arg))
      return $arg;
    elseif ($this->isFormatted($arg)) {
      if ($encode)
        return json_encode($arg);
      else
        return $arg;
    }
    else
      return $arg + 0;
  }


  /**
   * @brief Retrieves the connection in use.
   * @retval EoC::Couch The server connection.
   */
  protected function getConnection() {
    $shmKey = ftok($_SERVER['PHP_SELF'], 'c');

    if (@$shmId = shmop_open($shmKey, "a", 0, 0)) {
      // Gets shared memory block's size.
      $shmSize = shmop_size($shmId);

      // Now lets read the memory segment.
      if ($buffer = shmop_read($shmId, 0, $shmSize))
        $connection = unserialize($buffer);
      else
        throw new \RuntimeException("You are not connected to the server.");

      shmop_close($shmId);
    }
    else
      throw new \RuntimeException("You are not connected to the server.");

    return new Couch(new CurlAdapter($connection['server'], $connection['user'], $connection['password']));
  }


  /**
   * @brief Retrieves the database in use.
   * @retval string The database name.
   */
  protected function getDatabase() {
    $shmKey = ftok($_SERVER['PHP_SELF'], 'd');

    if (@$shmId = shmop_open($shmKey, "a", 0, 0)) {
      // Gets shared memory block's size.
      $shmSize = shmop_size($shmId);

      // Now lets read the memory segment.
      if ($buffer = shmop_read($shmId, 0, $shmSize))
        $database = $buffer;
      else
        throw new \RuntimeException("No database selected.");

      shmop_close($shmId);
    }
    else
      throw new \RuntimeException("No database selected.");

    return $database;
  }

}
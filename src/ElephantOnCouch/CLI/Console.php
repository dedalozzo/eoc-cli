<?php

/**
 * @file Console.php
 * @brief This file contains the Console class.
 * @details
 * @author Filippo F. Fadda
 */


/**
 * @brief This namespace contains the Console class.
 */
namespace ElephantOnCouch\CLI;


use Symfony\Component\Console\Application;


/**
 * @brief This class extends the Application class of Symfony framework, with methods aim to set the Phalcon Dependency
 * Injector.
 */
class Console extends Application {

  protected $_di;



}
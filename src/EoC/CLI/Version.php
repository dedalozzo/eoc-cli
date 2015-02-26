<?php

//! @file Version.php
//! @brief This file contains the Version class.
//! @details
//! @author Filippo F. Fadda


namespace EoC\CLI;


//! @brief This helper class is aimed to provide the software version number.
//! @details The version number is composed by a group of three numbers. The first one is the major release number, the
//! second one is the minor release number and the third one is used to identify the maintenance version.
class Version extends \EoC\Version {

  const MAJOR = '0'; //!< Major release number.
  const MINOR = '3'; //!< Minor release number.
  const MAINTENANCE = '0'; //!< Maintenance release number (bug fixes only).
} 
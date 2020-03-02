<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: util.php
 * Desc: Util file for Projekt
 *
 * Anders Student
 * ansu6543
 * ansu6543@student.miun.se
 ******************************************************************************/

/*******************************************************************************
 * autoload functions for Classes stored i directory classes
 * All classes must be saved i lower case to work and end whit class.php
 ******************************************************************************/
spl_autoload_register(function ($class) {
    $classfilename = strtolower($class);
    include './classes/' . $classfilename . '.class.php';
    // require((__DIR__) . "/classes/" . $classfilename . '.class.php');
});

$config = Config::getinstance();
//---------------------------------------------------------------------------

if ($config->isDebug()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

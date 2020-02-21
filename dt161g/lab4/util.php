<?php

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: util.php
 * Desc: Util file for Laboration 4
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
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

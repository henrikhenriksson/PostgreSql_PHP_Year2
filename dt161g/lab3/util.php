<?php

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: util.php
 * Desc: Util file for laboration 3
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

/*******************************************************************************
 * autoload functions for Classes stored i directory classes
 * All classes must be saved i lower case to work and end whit class.php
 ******************************************************************************/
// function my_autoloader($class)
// {
//     $classfilename = strtolower($class);
//     require_once 'classes/' . $classfilename . '.class.php';
// }
// spl_autoload_register('my_autoloader');
// Turn the function anonymous as it should be included in all files that passes through the PHP parser.
spl_autoload_register(function ($class) {
    $classfilename = strtolower($class);
    include 'classes/' . $classfilename . '.class.php';
});

// initialize a new config object to be used throughout the project.
$config = new Config();
//---------------------------------------------------------------------------

if ($config->isDebug()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

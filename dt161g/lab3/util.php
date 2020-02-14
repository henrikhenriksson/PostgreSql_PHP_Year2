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
spl_autoload_register(function ($class) {
    $classfilename = strtolower($class);
 //   include 'classes/' . $classfilename . '.class.php';
    require((__DIR__) . "/classes/" . $classfilename . '.class.php');
});

// initialize a new config object to be used throughout the project.
$config = new Config();

// initiate a new database handler.
$dbHandler = new dbHandler();

// determine wether or not the user is logged in, or if a cookie is set. Only valid users that are logged in should be able to post more than once.
$setShoworHide = (!(isset($_COOKIE['miunCookie'])) || isset($_SESSION['validLogin'])) ? "" : "hide";

//---------------------------------------------------------------------------

if ($config->isDebug()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

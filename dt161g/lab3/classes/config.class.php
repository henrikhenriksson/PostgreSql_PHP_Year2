<?php

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: config.class.php
 * Desc: Class Config for laboration 3
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

// require_once "../config.php";
require_once __DIR__ . "/../config.php";
class Config
{
    private $dsn = "";
    private $debug = true;

    public function getDbDsn()
    {
        return $this->dsn;
    }

    public function getCaptchaLength()
    {
        return $GLOBALS['captchaLenght'];
    }
    public function getHost()
    {
        return $GLOBALS['host'];
    }
    public function getUser()
    {
        // global $user;
        // return $user;
        // require "../config.php";
        return $GLOBALS['user'];
    }
    public function isDebug()
    {
        return $this->debug;
    }
    public function setDebub(Bool $value)
    {
        $this->debug = $value;
    }
}

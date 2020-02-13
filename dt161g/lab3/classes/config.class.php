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

class Config
{
    public function getDbDsn()
    {
        require __DIR__ . "/../config.php";

        return "host=$host port=$port dbname=$dbName user=$user password=$pass";
    }

    public function getCaptchaLength()
    {
        require __DIR__ . "/../config.php";
        return $captchaLength;
    }
    public function getHost()
    {
        require __DIR__ . "/../config.php";
        return $host;
    }
    public function getUser()
    {
        require __DIR__ . "/../config.php";
        return $user;
    }
    public function isDebug()
    {
        require __DIR__ . "/../config.php";
        return $debug;
    }
}

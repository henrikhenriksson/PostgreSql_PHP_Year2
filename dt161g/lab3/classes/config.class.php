<?php

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: config.class.php
 * Desc: Class Config for laboration 3. The class is mainly used to get variables from the config.php file.
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

class Config
{
    // private variable used to hold the config settings.
    private $setting;

    // load in the settings as they are when initializing the config class object.
    public function __construct()
    {
        require __DIR__ . "/../config.php";
        $this->setting = $confSettings;
    }

    public function getDbDsn()
    {


        return "host=" . $this->setting['host'] . " port=" . $this->setting['port'] . " dbname= " . $this->setting['dbName'] . " user=" . $this->setting['user'] . " password=" . $this->setting['pass'];
    }

    public function getCaptchaLength()
    {

        return $this->setting['captchaLength'];
    }

    public function isDebug()
    {

        return $this->setting['debug'];
    }
}

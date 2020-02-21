<?php

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: config.class.php
 * Desc: Class Config for Laboration 4. The class is mainly used to get variables from the config.php file.
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/
// Singleton class. Only one instance can exist at the time.
class Config
{
    private static $instance = null;
    // private variable used to hold the config settings.
    private $setting;
    private $memberLinks;
    private $adminLinks;


    // load in the settings as they are when initializing the config class object.
    private function __construct()
    {
        require __DIR__ . "/../config.php";
        $this->setting = $confSettings;
        $this->adminLinks = $admin_link_array;
        $this->memberLinks = $member_link_array;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Config();
        }
        return self::$instance;
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

    /**
     * Get the value of memberLinks
     */
    public function getMemberLinks()
    {
        return $this->memberLinks;
    }

    /**
     * Get the value of adminLinks
     */
    public function getAdminLinks()
    {
        return $this->adminLinks;
    }
}

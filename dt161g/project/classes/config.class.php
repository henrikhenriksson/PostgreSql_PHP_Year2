<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: config.class.php
 * Desc: Class Config for dt161g project
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 * 
 * Last edited: 2020-03-09
 ******************************************************************************/

/**
 * @brief this class is responsible for fetching and setting the global setting variables used throughout the application. The class is represented as a singleton.
 *
 */
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

    /**
     * This function returns the current instance of the class. If no instance exists when the function is called, one is initiated.
     *
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Config();
        }
        return self::$instance;
    }
    /**
     * This function is responsible for returning the value of the image target directory set in the Config file.
     * @return $this->setting['targetdir']
     */
    public function getTargetDir()
    {
        return $this->setting['targetdir'];
    }
    /**
     * This function is responsible for returning the an array of valid file types for images that has been set in the Config file.
     * @return $this->setting['validFileTypes']
     */
    public function getFileTypes()
    {
        return $this->setting['validFileTypes'];
    }

    /**
     * This function is responsible for returning the database DSN string used when connecting to the database
     * @return string
     */
    public function getDbDsn()
    {


        return "host=" . $this->setting['host'] . " port=" . $this->setting['port'] . " dbname= " . $this->setting['dbName'] . " user=" . $this->setting['user'] . " password=" . $this->setting['pass'];
    }

    /**
     * This function is responsible for setting the debug value to true or false.
     */
    public function isDebug()
    {

        return $this->setting['debug'];
    }

    /**
     * Get the value of the memberLinks variable.
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

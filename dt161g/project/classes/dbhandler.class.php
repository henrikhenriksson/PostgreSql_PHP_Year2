<?php

/*******************************************************************************
 * Laboration 4, Kurs: DT161G
 * File: config.php
 * Desc: dbHandler class file for Laboration 4
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

// This Singleton class is responsible for handling requests to the database.
// 
class dbHandler
{
    private static $instance = null;
    private $dbconn;
    private $dbDsn;

    private function __construct()
    {
        $dbconn = null;
        require __DIR__ . "/../util.php";
        $this->dbDsn = $config->getDbDsn();
    }

    // establish a connection to the server.
    private function connect()
    {
        $this->dbconn = pg_connect($this->dbDsn);
        return $this->dbconn;
    }
    // disconnect from the server.
    private function disconnect()
    {
        pg_close($this->dbconn);
    }

    //-------------------------------------------------------------------------
    // Public functions:
    //-------------------------------------------------------------------------

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new dbHandler();
        }
        return self::$instance;
    }

    // public function getCategoriesForUser()
    // {

    //     if ($this->connect()) {
    //         $queryStr = "SELECT * FROM dt161g_Project.category;";
    //     }
    // }

    //-------------------------------------------------------------------------
    public function getMembersFromDataBase()
    {
        if ($this->connect()) {
            $queryStr = "SELECT * FROM dt161g_project.member;";
            $result = pg_query($this->dbconn, $queryStr);

            if ($result) {

                for ($i = 0; $i < pg_num_rows($result); $i++) {
                    // fetch the result to a standard object.
                    $databaseObj = pg_fetch_object($result);
                    // Use the standard object values to create a new member object
                    $fetchedMember = new Member(
                        $databaseObj->id,
                        $databaseObj->username,
                        $databaseObj->password
                    );
                    // fetch the roles attached to the current iteration id number:
                    $roleArray = $this->getRolesFromDatabase($databaseObj->id);
                    // append the roles to the member object.
                    $fetchedMember->addRole($roleArray);
                    // add the Member object to array holding members.
                    $databaseMembers[] = $fetchedMember;
                }
                // free the results.
                pg_free_result($result);
                $this->disconnect();
            }
            //return the member array.
            return $databaseMembers;
        } else {
            return null;
        }
    }
    //-------------------------------------------------------------------------
    // This function returns an array of Roles attached to a parameter id
    private function getRolesFromDatabase($memberId)
    {
        $dataBaseRoles = [];

        $queryStr = "SELECT * FROM dt161g_project.role, dt161g_project.member_role WHERE dt161g_project.role.id = dt161g_project.member_role.role_id AND dt161g_project.member_role.member_id = {$memberId}";

        $result = pg_query($this->dbconn, $queryStr);

        for ($i = 0; $i < pg_num_rows($result); $i++) {
            $databaseObj = pg_fetch_object($result);
            $fetchedPost = new Role($databaseObj->id, $databaseObj->role, $databaseObj->roletext);
            $dataBaseRoles[] = $fetchedPost;
        }
        pg_free_result($result);
        return $dataBaseRoles;
    }
}
//---------------------------------------------------------------------------

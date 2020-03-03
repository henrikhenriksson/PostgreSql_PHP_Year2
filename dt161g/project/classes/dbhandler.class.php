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

    // Store a post to the database.
    public function storePostToDatabase(array $post)
    {
        if ($this->connect()) {

            $queryStr = "INSERT INTO dt161g.guestbook (name, message, iplog, timelog) VALUES($1,$2,$3,$4)";

            // by refering to the values as params we get some protection from code injections to the database.
            $result = pg_query_params($this->dbconn, $queryStr, $post);

            // returns message if the request was unsuccessful.
            if (!$result) {
                echo "Error sending request: <br>\n";
                pg_last_error($this->dbconn);
            }
            $this->disconnect();
        }
    }
    //-------------------------------------------------------------------------
    public function getMembersFromDataBase()
    {
        if ($this->connect()) {
            $queryStr = "SELECT * FROM dt161g.member;";
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
        // $queryStr = <<<SQL
        //         SELECT *
        //         FROM dt161g.role, dt161g.member_role
        //         WHERE dt161g.role.id = dt161g.member_role.role_id
        //         AND dt161g.member_role.member_id = $memberId;
        //     SQL;

        $queryStr = "SELECT * FROM dt161g.role, dt161g.member_role WHERE dt161g.role.id = dt161g.member_role.role_id AND dt161g.member_role.member_id = {$memberId}";

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

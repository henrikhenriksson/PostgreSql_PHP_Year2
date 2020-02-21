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

    // Load the posts from the database to print on the website.
    // returns a Post[]
    public function getPostsFromDatabase()
    {

        $databasePosts = [];

        if ($this->connect()) {

            $queryStr = "SELECT * FROM dt161g.guestbook;";
            $result = pg_query($this->dbconn, $queryStr);

            // the query fetches an object, which is then inserted into a Post class object that is then added to an array of Post objects.
            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $databaseObj = pg_fetch_object($result);
                $fetchedPost = new Post($databaseObj->name, $databaseObj->message, $databaseObj->iplog, $databaseObj->timelog);

                $databasePosts[] = $fetchedPost;
            }
            // free the resources.
            pg_free_result($result);
            $this->disconnect();
        }
        return $databasePosts;
    }
    //-------------------------------------------------------------------------
    public function getMembersFromDataBase()
    {

        $dataBaseMembers = [];

        if ($this->connect()) {

            $queryStr = "SELECT * FROM dt161g.member";
            $result = pg_query($this->dbconn, $queryStr);

            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $databaseObj = pg_fetch_object($result);
                $fetchedPost = new Member($databaseObj->id, $databaseObj->username, $databaseObj->password);
                $databaseMembers[] = $fetchedPost;
            }
            pg_free_result($result);
            $this->disconnect();
        }
        return $databaseMembers;
    }
    //-------------------------------------------------------------------------
    public function getRolesFromDatabase()
    {

        $dataBaseRoles = [];

        if ($this->connect()) {


            $queryStr = <<<SQL
                SELECT *
                FROM dt161g.role;
            SQL;
            $result = pg_query($this->dbconn, $queryStr);

            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $databaseObj = pg_fetch_object($result);
                $fetchedPost = new Role($databaseObj->id, $databaseObj->role, $databaseObj->roletext);
                $databaseMembers[] = $fetchedPost;
            }
            pg_free_result($result);
            $this->disconnect();
        }
        return $databaseMembers;
    }
}
//---------------------------------------------------------------------------

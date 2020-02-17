<?php

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: config.php
 * Desc: dbHandler class file for laboration 3
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

// this class is responsible for handling requests to the database.
class dbHandler
{
    private $dbconn;
    private $dbDsn;

    public function __construct()
    {
        $dbconn = null;
        require __DIR__ . "/../util.php";
        $this->dbDsn = $config->getDbDsn();
    }

    // establish a connection to the server.
    public function connect()
    {
        $this->dbconn = pg_connect($this->dbDsn);
        return $this->dbconn;
    }
    // disconnect from the server.
    public function disconnect()
    {
        pg_close($this->dbconn);
    }

    // Store a post to the database.
    function storePostToDatabase(array $post)
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
    function getPostsFromDatabase()
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
}

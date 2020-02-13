<?php

/*******************************************************************************
 * Laboration 3, Kurs: DT161G
 * File: config.php
 * Desc: Config file for laboration 3
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/


class dbHandler
{
    private $dbconn;

    public function __construct()
    {
        $dbconn = null;
    }

    public function connect()
    {
        require __DIR__ . "/../util.php";
        $this->dbconn = pg_connect($config->getDbDsn());
        return $this->dbconn;
    }
    public function disconnect()
    {
        pg_close($this->dbconn);
    }

    function storePostToDatabase(array $post)
    {
        if ($this->connect()) {

            $queryStr = "INSERT INTO dt161g.guestbook (name, message, iplog, timelog) VALUES('$post[name]', '$post[message]', '$post[iplog]', '$post[timelog]')";
            $result = pg_query($this->dbconn, $queryStr);
            $this->disconnect();
        }
    }
    function getPostsFromDatabase()
    {

        $databasePosts = [];

        if ($this->connect()) {

            $queryStr = "SELECT * FROM dt161g.guestbook;";
            $result = pg_query($this->dbconn, $queryStr);

            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $databaseObj = pg_fetch_object($result);
                $fetchedPost = new Post($databaseObj->name, $databaseObj->message, $databaseObj->iplog, $databaseObj->timelog);

                $databasePosts[] = $fetchedPost;
            }

            pg_free_result($result);
            $this->disconnect();
        }
        return $databasePosts;
    }
}

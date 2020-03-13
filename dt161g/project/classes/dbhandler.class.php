<?php

/*******************************************************************************
 * Project Assignment Kurs: DT161G
 * File: config.php
 * Desc: dbHandler class file for dt161g project
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/


/**
 * This class is the database handler. It is responsible for handling all requests to the database. It is represented as a singleton.
 */
class dbHandler
{
    private static $instance = null;
    private $dbconn;
    private $dbDsn;

    /**
     * Private constructor setting the connection string to the database.
     */
    private function __construct()
    {
        $dbconn = null;
        require __DIR__ . "/../util.php";
        $this->dbDsn = $config->getDbDsn();
    }

    /**
     * Used to establish a connection to the server.
     */
    private function connect()
    {
        $this->dbconn = pg_connect($this->dbDsn);
        return $this->dbconn;
    }
    /**
     * Used to end the connection to the server.
     */
    private function disconnect()
    {
        pg_close($this->dbconn);
    }

    //-------------------------------------------------------------------------
    // Public functions:
    //-------------------------------------------------------------------------

    /**
     * This function is used to get the current instance of the class. If no class instance is set, one is iniatated calling the private constructor.
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new dbHandler();
        }
        return self::$instance;
    }

    /**
     * This function is responsible for uploading information about an image to the database.
     */
    public function addNewImage($imgName, $dateTime, $category_Id)
    {
        if ($this->connect()) {
            $queryStr = "INSERT INTO dt161g_project.image (img_name, img_date, category_id) VALUES($1,$2,$3)";

            $result = pg_query_params($this->dbconn, $queryStr, array($imgName, $dateTime, $category_Id));

            if (!$result) {
                echo "Error sending request: <br>\n";
                pg_last_error($this->dbconn);
            }
            $this->disconnect();
        }
    }
    //-------------------------------------------------------------------------
    /**
     * This function is used to upload information about a new category to the server.
     */
    public function addNewCategory($name, $memberid)
    {
        if ($this->connect()) {
            $queryStr = "INSERT INTO dt161g_project.category (category_name, member_id) VALUES($1,$2)";

            $result = pg_query_params($this->dbconn, $queryStr, array($name, $memberid));

            if (!$result) {
                echo "Error sending request: <br>\n";
                pg_last_error($this->dbconn);
            }
            $this->disconnect();
        }
    }
    //-------------------------------------------------------------------------
    public function addNewUser($newUserName, $newUserPsw, $newUserRoles)
    {
        if ($this->connect()) {
            $queryStr = "INSERT INTO dt161g_project.member (username, password) VALUES($1,$2) RETURNING id;";
            $result = pg_query_params($this->dbconn, $queryStr, array($newUserName, $newUserPsw));

            $newUserId = pg_fetch_result($result, null, 'id');

            foreach ($newUserRoles as $key) {
                $this->addNewMemberRoles($newUserId, $key);
            }

            if (!$result) {
                echo "Error sending request: <br>\n";
                pg_last_error($this->dbconn);
            }

            $this->disconnect();
        }
    }
    //-------------------------------------------------------------------------
    private function addNewMemberRoles(int $newUserId, int $newUserRoleId)
    {

        $queryStr = "INSERT INTO dt161g_project.member_role (member_id, role_id) VALUES($1,$2);";
        $result = pg_query_params($this->dbconn, $queryStr, array($newUserId, $newUserRoleId));

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    public function removeUser($memberId)
    {
        if ($this->connect()) {

            $queryStr = "DELETE FROM dt161g_project.member WHERE id = $1;";
            $result = pg_query_params($this->dbconn, $queryStr, array($memberId));

            if (!$result) {
                echo "Error sending request: <br>\n";
                pg_last_error($this->dbconn);
            }
            $this->disconnect();
        }
    }
    //-------------------------------------------------------------------------

    /**
     * This functions sends a request to the database to remove a specific category from a member.
     * @param int the category id.
     */
    public function removeCategory(int $categoryId)
    {
        if ($this->connect()) {
            $queryStr = "DELETE FROM dt161g_project.category WHERE id = $1;";

            $result = pg_query_params($this->dbconn, $queryStr, array($categoryId));

            if (!$result) {
                echo "Error sending request: <br>\n";
                pg_last_error($this->dbconn);
            }
            $this->disconnect();
        }
    }
    //-------------------------------------------------------------------------
    /**
     * This functions sends a request to the database to get all categories related to the member id.
     * @param $memberId, the id of the member to get the categories for.
     * @return $databaseCategories[], an array holding category object.
     */
    public function getCategoriesForUser($memberId)
    {
        $databaseCategories = [];

        $queryStr = "SELECT * FROM dt161g_project.category WHERE member_id = {$memberId};";

        $result = pg_query($this->dbconn, $queryStr);

        if ($result) {
            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $databaseObj = pg_fetch_object($result);

                $fetchedCategory = new Category(
                    $databaseObj->id,
                    $databaseObj->category_name,
                    $databaseObj->member_id
                );

                $imageArray = $this->getImagesForUser($databaseObj->id);
                $fetchedCategory->setImages($imageArray);
                $databaseCategories[] = $fetchedCategory;
            }
            pg_free_result($result);
        }
        return $databaseCategories;
    }
    //---------------------------------------------------------------------------
    /**
     * This function sends a request to the database to get all images related to a specific category
     * @param $categoryId, the id of the current category
     * @return $databaseImages[]
     */
    public function getImagesForUser($categoryId)
    {
        $databaseImages = [];

        $queryStr = "SELECT * FROM dt161g_project.image WHERE dt161g_project.image.category_id = {$categoryId}";

        $result = pg_query($this->dbconn, $queryStr);

        if ($result) {
            for ($i = 0; $i < pg_num_rows($result); $i++) {
                $databaseObj = pg_fetch_object($result);
                $fetchedImage = new Image($databaseObj->id, $databaseObj->img_name, $databaseObj->img_date, $databaseObj->category_id);
                $databaseImages[] = $fetchedImage;
            }
            pg_free_result($result);
        }
        return $databaseImages;
    }
    //-------------------------------------------------------------------------
    /**
     * This function returns an array of Roles attached to a parameter id
     * @param $memberId the id of the member
     * @return $dataBaseRoles[]
     */
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
    //-------------------------------------------------------------------------
    /**
     * This function sends request to fetch all members from the database. It calls subfunctions that in turns sends subsequent requests to fetch categories and images. This function is also responsible for opening and closing the connection.
     * @return $databaseMembers[]
     */
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
                    // fetch the categories related to the current member.
                    $categoryArray = $this->getCategoriesForUser($databaseObj->id);
                    // append the roles to the member object.
                    $fetchedMember->addRole($roleArray);
                    // append the categories to the member 
                    $fetchedMember->setCategories($categoryArray);
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
}
//---------------------------------------------------------------------------

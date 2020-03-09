<?php

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: member.class.php
 * Desc: Member class file for dt161g Project Assignment
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

/**
 * This class represents an individual member as found in the database.
 */
class Member
{
    private $id;
    private $userName;
    private $password;
    private $roles;
    private $categories;

    /** 
     * Public constructor setting member variable values and initiating role and category arrays.
     * @param $pId, the id to set
     * @param $pUserName, the userName to set
     * @param $pPassword, the password to set
     *  */
    public function __construct(int $pId, string $pUserName, string $pPassword)
    {
        $this->id = $pId;
        $this->userName = $pUserName;
        $this->password = $pPassword;
        $this->roles = [];
        $this->categories = [];
    }

    /**
     * Get the value of id
     * @return $this->id;
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Get the value of userName
     * @return $this->userName;
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Get the value of password
     * @return $this->password;
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Return this member object as an array entry.
     */
    public function getMemberAsArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->userName,
            'password' => $this->password
        ];
    }

    /**
     * Get the value of the roles array
     * @return $this->roles;
     */
    public function getRoleArray()
    {
        return $this->roles;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function addRole(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set the value of categories
     *
     * @return  self
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get the value of categories
     * @return $this->categories;
     */
    public function getCategories()
    {
        return $this->categories;
    }
}

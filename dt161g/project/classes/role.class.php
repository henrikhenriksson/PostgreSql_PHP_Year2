<?php

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: role.class.php
 * Desc: Role Class file for dt161g Project Assignment
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

/**
 * This class represents a role a member can have in the database, either member or admin.
 */
class Role
{
    private $id;
    private $role;
    private $roleText;

    /**
     *  Public constructor setting member variables
     * @param $pId, the id to set
     * @param $pRole, the role to set
     * @param $pRoleText, the roleText to set
     */
    public function __construct(int $pId, string $pRole, string $pRoleText)
    {
        $this->id = $pId;
        $this->role = $pRole;
        $this->roleText = $pRoleText;
    }

    /**
     * Get the value of role
     * @return $this->role;
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the value of roleText
     * @return $this->roleText;
     */
    public function getRoleText()
    {
        return $this->roleText;
    }

    /**
     * Get the value of id
     * @return $this->id;
     */
    public function getId()
    {
        return $this->id;
    }
}

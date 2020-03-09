<?php

/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: role.class.php
 * Desc: Category class file for dt161g project.
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 * 
 * Last edited: 2020-03-09
 ******************************************************************************/

/**
 * * @brief this class represents a category object used in the image.php. It is responsible for holding information about a specific category a user has created, and related images this category contains.
 */
class Category
{

    private $id;
    private $categoryname;
    private $memberid;
    private $images;

    /**
     *  @brief public constructor used to set member variables and initiating the images array that will be loaded in the database handler.
     *  @param $pId, the category id to set.
     *  @param $pCategoryName the category name to set
     *  @param $memberId, the member id value to set
     */
    public function __construct(int $pId, string $pCategoryName, int $memberId)
    {
        $this->id = $pId;
        $this->categoryname = $pCategoryName;
        $this->memberid = $memberId;
        $this->images = [];
    }

    /**
     * Get the value of id
     *  @return $this->id, the category id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of categoryname
     *  @return $this->categoryname
     */
    public function getCategoryName()
    {
        return $this->categoryname;
    }

    /**
     * Get the value of memberid
     *  @return $this->memberid
     */
    public function getMemberid()
    {
        return $this->memberid;
    }

    /**
     * Get the value of images
     * @return $this->images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set the value of images
     *
     * @return  self
     */
    public function setImages(array $images)
    {
        $this->images = $images;

        return $this;
    }
}

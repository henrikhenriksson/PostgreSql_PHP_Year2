<?php

/*******************************************************************************
 * Projekt, Kurs: DT161G
 * File: image.class.php
 * Desc: Class Image for Projekt
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

/**
 * This class represents an image that has been uploaded to the database.
 */
class Image
{
    private $id;
    private $imgName;
    private $categoryId;

    /**
     * Public constructor
     * @param $pId, the id of the image
     * @param $pImgName, the name of the image.
     * @param $pCategoryId, the id of the category the image adheres to.
     */
    public function __construct(int $pId, string $pImgName, int $pCategoryId)
    {
        $this->id = $pId;
        $this->imgName = $pImgName;
        $this->categoryId = $pCategoryId;
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
     * Get the value of img_name
     * @return $this->imgName;
     */
    public function getImgName()
    {
        return $this->imgName;
    }

    /**
     * Get the value of category_id
     * @return $this->categoryId
     */
    public function getCategory_id()
    {
        return $this->categoryId;
    }
}

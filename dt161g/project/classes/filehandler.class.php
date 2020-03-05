<?php

/*******************************************************************************
 * Project, Kurs: DT161G
 * File: login.php
 * Desc: Login page for laboration 2
 *
 * Henrik Henriksson
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

class FileHandler
{
    private static $instance = null;
    private $responseText;
    private $validUpload;
    private $validFileTypes;
    private $targetDir;
    //-------------------------------------------------------------------------
    private function __construct()
    {
        // require __DIR__ . "/../config.php";
        $this->responseText = [];
        $this->validFileTypes = Config::getInstance()->getFileTypes();
        $this->targetDir = Config::getInstance()->getTargetDir();
    }
    //-------------------------------------------------------------------------
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new FileHandler();
        }
        return self::$instance;
    }
    //-------------------------------------------------------------------------
    public function createCategoryFolder($memberName, $categoryName)
    {
        $dirToCreate = "{$this->targetDir}/{$memberName}/{$categoryName}/";
        if ($this->validateTargetFolder($dirToCreate)) {
            mkdir($dirToCreate, 0777, true);
        }
    }
    //-------------------------------------------------------------------------
    public function createUserFolder($memberName)
    {
        $dirToCreate = "{$this->targetDir}/{$memberName}/";
        if ($this->validateTargetFolder($dirToCreate)) {
            mkdir($dirToCreate, 0777, true);
        }
    }
    //-------------------------------------------------------------------------
    public function validateAndUpload($currentUser, $category, $FILES)
    {
        $this->validUpload = false;

        $currentCategoryId = "";

        foreach ($currentUser->getCategories() as $key) {
            if ($category === $key->getCategoryName()) {
                $currentCategoryId = $key->getId();
            }
        }

        $targetFile = "{$this->targetDir}/{$currentUser->getUserName()}/{$category}/" . basename($FILES["file"]["name"]);
        $imgExt = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (self::isImage($FILES)) {
            if (self::isNotDupe($targetFile)) {
                if (self::isNotLarge($FILES)) {
                    if (self::isValidFileType($imgExt)) {
                        $this->validUpload = true;
                    } else {
                        $this->responseText['msg'] = "Invalid Filetype. Files should only end with gif, jpeg, jpg or png";
                    }
                } else {
                    $this->responseText['msg'] = "File Size is too large. Image could not be uploaded";
                }
            } else {
                $this->responseText['msg'] = "This file already exists on the database. Image could not be uploaded.";
            }
        } else {
            $this->responseText['msg'] = "The file you tried to upload is not an image. File could not be uploaded.";
        }

        if ($this->validUpload) {
            if (move_uploaded_file($FILES["file"]["tmp_name"], $targetFile)) {
                dbHandler::getInstance()->addNewImage(basename($FILES["file"]["name"]), $currentCategoryId);
                $this->responseText['msg'] = "The file " . basename($FILES["file"]["name"]) . " has been uploaded.";
            } else {
                $this->responseText['msg'] =  "Sorry, there was an error that was probably not your fault uploading your file.";
            }
        }
    }
    //-------------------------------------------------------------------------
    private function isImage(array $FILES)
    {
        if (getimagesize($FILES['file']['tmp_name'])) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    private function isNotDupe($targetFile)
    {
        if (!file_exists($targetFile)) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    private function isNotLarge($FILES)
    {
        if ($_FILES['file']['size'] < 5000001) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    private function isValidFileType($extension)
    {
        if (in_array($extension, $this->validFileTypes)) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    private function validateTargetFolder($targetDir)
    {
        if (!file_exists($targetDir)) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------------------------------------------------------------
    public function sendReply()
    {
        // send the reply.
        header('Content-Type: application/json');
        echo json_encode($this->responseText);
    }
}
//---------------------------------------------------------------------------

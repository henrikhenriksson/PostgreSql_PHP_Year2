    <!-- 
/*******************************************************************************
 * Project Assignment, Kurs: DT161G
 * File: includeUpload.php
 * Desc: upload html page for dt161g Project Assignment
 *
 * Henrik Henriksson 
 * hehe0601
 * hehe0601@student.miun.se
 ******************************************************************************/

     -->

    <!-- This page contains html tags related to category settings and the upload option on the member.php page -->
    <div id="categoryDiv">
        <p>Create a new Category</p>
        <form id="categoryForm" action="userpage.php" method="POST">
            <input type="text" name="newCategory" id="newCategory">
            <button type="submit" id="categoryButton">Create Category</button>
        </form>
        <p id="categoryStatus"></p>
    </div>

    <div id="uploadDiv">
        <form id="uploadForm">
            <p>Select Image to Upload</p>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <p>Select a Category</p>
            <button type="button" id="uploadButton">Upload Image</button>
        </form>
        <p id="uploadStatus"></p>
    </div>
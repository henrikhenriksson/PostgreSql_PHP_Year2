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
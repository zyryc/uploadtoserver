<?php
// script to upload a file to the server
// the file is stored in the directory "upload"

// check if the file has been uploaded
if(isset($_FILES['userfile'])) {
	// set the path to the upload folder
	$path = "upload/";
    // upload multiple files
    if(is_array($_FILES['userfile']['name'])) {
        // loop through each file
        for($i=0; $i<count($_FILES['userfile']['name']); $i++) {
            // get the temporary file path
            $tmpFilePath = $_FILES['userfile']['tmp_name'][$i];
            // make sure we have a filepath
            if ($tmpFilePath != ""){
                // save the filename
                $shortname = $_FILES['userfile']['name'][$i];
                // save the url and the file
                $filePath = $path."/".$shortname;
                // upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {
                    // success
                    $files[] = $shortname;
                } else {
                    // failure
                    $errors[] = "There was a problem uploading your file.";
                }
            }
        }
    } else {
        // get the file path
        $tmpFilePath = $_FILES['userfile']['tmp_name'];
        // make sure we have a filepath
        if ($tmpFilePath != ""){
            // save the filename
            $shortname = $_FILES['userfile']['name'];
            // save the url and the file
            $filePath = $path."/".$shortname;
            // upload the file into the temp dir
            if(move_uploaded_file($tmpFilePath, $filePath)) {
                // success
                $files[] = $shortname;
            } else {
                // failure
                $errors[] = "There was a problem uploading your file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- navigation bar -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="download.php">Downloads</a></li>
        </ul>
    </nav>
    <!-- html for multiple file upload -->
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="userfile[]" multiple>
        <input type="submit" value="Upload">
    </form>

    <!-- php code to read files in upload folder -->
    <?php
    // initiate imagelist array
    $imagelist = array();
    // initialize otherfile arrays
    $otherfiles = array();
    // initialize videos array
    $videos = array();


    // set the path to the upload folder
    $path = "upload/";
    // open the folder
    $dir_handle = @opendir($path) or die("There is an error with your image directory!");
    // loop through the files
    while ($file = readdir($dir_handle)) {
        if($file == "." || $file == "..") {
            continue;
        }
        // check if the file is an image
        $ext = strtolower(substr($file, strrpos($file, '.') + 1));
        if(in_array($ext, array("gif", "jpg", "png"))) {
            // get the image src
            $src = $path.$file;
            // print out the image
            //push the image into the array
            $imagelist[] = $src;
            
        }else if(in_array($ext, array("mp4", "avi", "mov"))) {
            // get the video src
            $src = $path.$file;
            // print out the video
            //push the video into the array
            $videos[] = $src;
        }else {
            // get the file path
            $src = $path.$file;
            // print out the file
            //push the file into the array
            $otherfiles[] = $src;
        }
        // check if the file is an other file

    }
    // close the folder
    closedir($dir_handle);
    ?>
    <!-- html for displaying images -->
    <?php
    // check if the array is empty
    if(!empty($imagelist)) { ?>
    <section>
        <div class="images">
            <h2>Images</h2>
            <?php
    // loop through the array
    foreach($imagelist as $image) {
        // print out the image
        echo '<img src="'.$image.'" width="200" height="200" />';
    }
    ?>
        </div>
    </section>
    <?php
    }
    ?>
    <!-- html for displaying videos -->
    <?php
    // check if the array is empty
    if(!empty($videos)) { ?>
    <section>
        <div class="videos">
            <h2>Videos</h2>
            <?php
    // loop through the array
    foreach($videos as $video) {
        // print out the video
        echo '<video width="320" height="240" controls>
        <source src="'.$video.'" type="video/mp4">
        Your browser does not support the video tag.
        </video>';
    }
    ?>
        </div>
    </section>
    <?php
    }
    ?>
    <!-- html for displaying other files -->
    <?php
    // check if the array is empty
    if(!empty($otherfiles)) { ?>
    <section>
        <div class="otherfile">
            <h2>Other Files</h2>
            <?php
    // loop through the array
    foreach($otherfiles as $otherfile) {
        // print out the file
        echo '<a href="'.$otherfile.'">'.$otherfile.'</a>';
    }
    ?>
        </div>
    </section>

    <?php
    }
    ?>

    <style>
    /* style navigation bar */
    nav {
        background-color: #333;
        padding: 10px;
        text-align: center;
    }

    nav ul {
        list-style: none;
        padding: 0;
    }

    nav ul li {
        display: inline-block;
        padding: 10px;
    }

    nav ul li a {
        color: #fff;
        text-decoration: none;
    }

    nav ul li a:hover {
        color: #ccc;
    }

    body {
        background-color: #f5f5f5;
    }

    /* image styling */
    img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 150px;
        height: 150px;
    }

    form {
        display: block;
        margin: 20px auto;
        background: #eee;
        border-radius: 10px;
        padding: 15px;
    }

    input[type="file"] {
        display: block;
        margin: 20px auto;
        background: #eee;
        border-radius: 10px;
        padding: 15px;
    }

    /* style the sections  */
    section {
        display: block;
        margin: 20px auto;
        background: #eee;
        border-radius: 10px;
        padding: 15px;
    }
    /* center section items */
    section div {
        display: block;
        margin: 20px auto;
        background: #eee;
        border-radius: 10px;
        padding: 15px;
    }
    </style>
</body>

</html>
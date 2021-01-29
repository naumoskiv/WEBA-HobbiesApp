<?php

    include("classes/autoload.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['hobbies_userid']);

    if($_SERVER['REQUEST_METHOD'] == "POST") {

        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
            $allowed_size = 1024 * 1024 * 3;
            if ($_FILES['file']['type'] == "image/jpeg") {
                if ($_FILES['file']['size'] < $allowed_size) {

                    $folder = "uploads/" . $user_data['userid'] . "/";

                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                    }

                    $image = new Image();

                    $filename = $folder . $image->generate_filename(16);
                    move_uploaded_file($_FILES['file']['tmp_name'], $filename );

                    $change = "profile";

                    if (isset($_GET['change'])) {
                        $change = $_GET['change'];
                    }


                    if($change == "cover") {
                        if(file_exists($user_data['cover_image'])){
                            unlink($user_data['cover_image']);
                        }
                        //1366, 488
                        $image->resize_image($filename, $filename, 1500, 1500);
                    }
                    else {
                        if(file_exists($user_data['profile_image'])){
                            unlink($user_data['profile_image']);
                        }
                        $image->resize_image($filename, $filename, 1500, 1500);
                    }


                    if(file_exists($filename)) {
                        $userid = $user_data['userid'];

                        if($change == "cover") {
                            $query = "update users set cover_image = '$filename' where userid = '$userid' limit 1";
                            $_POST['is_cover_image'] = 1;
                        }
                        else {
                            $query = "update users set profile_image = '$filename' where userid = '$userid' limit 1";
                            $_POST['is_profile_image'] = 1;
                        }



                        $DB = new Database();
                        $DB->save($query);


                        //Create a post for profile image change
                        $post = new Post();
                        $post->create_post($userid, $_POST, $filename);


                        header("Location: profile.php");
                        die;
                    }

                }
                else {
                    echo "<div>";
                    echo "The following errors occured:<br><br>";
                    echo "Maximum file size allowed is 3MB.<br>";
                    echo "</div>";
                }
            }
            else {
                echo "<div>";
                echo "The following errors occured:<br><br>";
                echo "The file is not supported. JPEG required.<br>";
                echo "</div>";
            }
        }
        else {
            echo "<div>";
            echo "The following errors occured:<br><br>";
            echo "Please enter a valid image.<br>";
            echo "</div>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hobbies App - Change Profile Image</title>
    </head>


    <style>
        #profile_bar{
            height: 50px;
            background-color: cadetblue;
            color: white;
        }
        #search_box{
            width: 400px;
            height: 20px;
            border-radius: 5px;
            border: none;
            padding: 5px;
            font-size: 14px;
            background-image: url("search.png");
            background-repeat: no-repeat;
            background-position: right;
        }
        #post_button{
            float: right;
            background-color: cadetblue;
            border: none;
            color: white;
            padding: 5px;
            font-size: 14px;
            border-radius: 3px;
        }
        #post_bar{
            margin-top: 20px;
            background-color: white;
            padding: 10px;
        }
        #post{
            padding: 4px;
            font-size: 15px;
            display: flex;
            margin-bottom: 20px;
        }
    </style>



    <body style="font-family: Tahoma,serif; background-color: #eee">

    <?php include("header.php"); ?>

    <div id="profile_content" style="width: 800px; margin: auto; min-height: 400px;">


        <div style="display: flex">


            <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0">

                <form method="post" enctype="multipart/form-data">
                    <div style=" padding: 10px; background-color: white">
                        <input type="file" name="file">
                        <input type="submit" id="post_button" value="Change">
                        <br>
                        <br>

                        <div style="text-align: center">
                            <?php
                            $change = "profile";

                            if (isset($_GET['change']) && $_GET['change'] == "cover") {
                                $change = "cover";
                                echo "<img src ='$user_data[cover_image]' style='max-width: 600px'>";
                            }
                            else {
                                echo "<img src ='$user_data[profile_image]' style='max-width: 500px'>";
                            }

                            ?>
                        </div>


                    </div>
                </form>

            </div>

        </div>

    </div>

    </body>
</html>
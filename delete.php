<?php

    include("classes/autoload.php");


    $login = new Login();
    $image_class = new Image();
    $Post = new Post();
    $DB = new Database();

    $user_data = $login->check_login($_SESSION['hobbies_userid']);

    $USER = $user_data;

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);
        if (is_array($profile_data)) {
            $user_data = $profile_data[0];
        }
    }

    $_SESSION['return_to'] = "profile.php";
    if (isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "delete.php")) {
        $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
    }

    $ERROR = "";
    if (isset($_GET['id'])) {
        $ROW = $Post->get_one_post($_GET['id']);

        if (!$ROW) {
            $ERROR = "No such post was found";
        }
        else {
            if ($ROW['userid'] != $_SESSION['hobbies_userid']) {
                $ERROR = "Access Denied";
            }
        }
    }
    else {
        $ERROR = "No such post was found";
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $Post->delete_post($_POST['postid']);
        header("Location: ". $_SESSION['return_to']);
        die;
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hobbies App - Delete</title>
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
        #profile_photo{
            width: 150px;
            border-radius: 50%;
            border: solid 5px white;
        }
        #menu_buttons{
            width: 100px;
            display: inline-block;
            margin: 3px;
        }
        #hobby_image{
            width: 55px;
            float: left;
            margin: 10px;
        }
        #me_bar{
            min-height: 400px;
            margin-top: 20px;
            padding: 5px;
            text-align: center;
            font-size: 20px;
        }
        #hobbies{
            clear: both;
        }
        textarea{
            width: 100%;
            border: none;
            font-family: Tahoma, serif;
            font-size: 14px;
            height: 60px;
        }
        #post_button{
            float: right;
            background-color: cadetblue;
            border: none;
            color: white;
            padding: 5px;
            font-size: 14px;
            border-radius: 3px;
            width: 50px;
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
                <div style=" padding: 10px; background-color: white">
                    <h3>Delete Post</h3>
                    <form method="post">
                            <?php
                                if ($ERROR != "") {
                                    echo $ERROR;
                                }
                                else {
                                    if ($ROW) {
                                        echo "Are you sure you want to delete this post?<br><br>";
                                        $user = new User();
                                        $ROW_USER = $user->get_user($ROW['userid']);
                                        include("post_delete.php");
                                    }
                                    echo "<input type='hidden' name='postid' value='$ROW[postid]'>";
                                    echo "<input type='submit' id='post_button' value='Delete'>";
                                }

                            ?>
                        <br>

                    </form>

                    <br>
                </div>

            </div>

        </div>

    </div>

    </body>
</html>
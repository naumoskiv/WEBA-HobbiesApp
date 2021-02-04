<?php
    include("classes/autoload.php");


    $login = new Login();
    $user_data = $login->check_login($_SESSION['hobbies_userid']);

    $USER = $user_data;

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);
        if (is_array($profile_data)) {
            $user_data = $profile_data[0];
        }
    }





    //posting posts
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        if (isset($_POST['first_name'])) {
            $settings_class = new Settings();
            $settings_class->save_settings($_POST, $_SESSION['hobbies_userid']);
        }
        else {
            $id = $_SESSION['hobbies_userid'];
            $post = new Post();
            $result = $post->create_post($id, $_POST, $_FILES);

            if($result == "") {
                header("Location: profile.php");
            }
            else {
                echo "<div>";
                echo "The following errors occured:<br><br>";
                echo $result;
                echo "</div>";
            }
        }

    }

    //getting posts
    $id = $user_data['userid'];
    $post = new Post();
    $posts = $post->get_posts($id);


    $user = new User();
    $friends = $user->get_following($user_data['userid'], "user");

    $image_class = new Image();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hobbies App - Profile</title>
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
        #textbox{
            width: 100%;
            height: 20px;
            border-radius: 5px;
            padding: 5px;
            font-size: 14px;
            border: solid thin grey;
            margin: 10px;
        }
        #profile_photo{
            width: 150px;
            margin-top: -200px;
            border-radius: 50%;
            border: solid 3px white;
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
        #hobbies_bar{
            background-color: white;
            min-height: 400px;
            margin-top: 20px;
            padding: 5px;
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
            cursor: pointer;
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
            <div style="background-color: white; text-align: center; ">

                <?php
                    $image = "images/cover_image.jpg";
                    if (file_exists($user_data['cover_image'])) {
                        $image = $image_class->get_thumbnail_cover($user_data['cover_image']);
                    }
                ?>

                <img src="<?php echo $image; ?>" style="width: 100%">

                <?php
                    $my_likes = $user_data['likes'];
                ?>

                <a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>">
                    <input type="button" id="post_button" value="Follow">
                </a>


                <span>

                    <?php

                        $image = "images/user_male.jpg";
                        if ($user_data['gender'] == "Female") {
                            $image = "images/user_female.jpg";
                        }
                        if (file_exists($user_data['profile_image'])) {
                            $image = $image_class->get_thumbnail_profile($user_data['profile_image']);

                        }
                    ?>
                    <img id="profile_photo" src="<?php echo $image; ?>"> <br>
                    <?php
                    if ($user_data['userid'] == $_SESSION['hobbies_userid']) {
                        echo '<a href="change_profile_image.php?change=profile" style="text-decoration: none; color: #999999"> Change Profile Image </a>';
                        echo '|';
                        echo '<a href="change_profile_image.php?change=cover" style="text-decoration: none; color: #999999"> Change Cover</a>';
                    }

                    ?>


                </span>
                <br>
                <div style="font-size: 22px"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></div>
                <div><?php echo $my_likes ?> Followers</div>
                <br>
                <a href="index.php"><div id="menu_buttons">Timeline</div></a>
                <a href="profile.php?section=about"><div id="menu_buttons">About</div></a>
                <a href="profile.php?section=following&id=<?php echo $user_data['userid']?>"><div id="menu_buttons">Following</div></a>
                <a href="profile.php?section=followers&id=<?php echo $user_data['userid']?>"><div id="menu_buttons">Followers</div></a>
                <a href="profile.php?section=photos&id=<?php echo $user_data['userid']?>"><div id="menu_buttons">Photos</div></a>
                <?php
                    if ($user_data['userid'] == $_SESSION['hobbies_userid']) {
                        echo '<a href="profile.php?section=settings&id=' . $user_data['userid'] .'"><div id="menu_buttons">Settings</div></a>';
                    }

                ?>

            </div>

            <?php
                $section = "default";
                if (isset($_GET['section'])) {
                    $section = $_GET['section'];
                }

                if ($section == "default") {
                    include("profile_content_default.php");
                }
                elseif ($section == "photos"){
                    include("profile_content_photos.php");
                }
                elseif ($section == "followers"){
                    include("profile_content_followers.php");
                }
                elseif ($section == "following"){
                    include("profile_content_following.php");
                }
                elseif ($section == "settings"){
                    include("profile_content_settings.php");
                }
                elseif ($section == "about"){
                    include("profile_content_about.php");
                }
            ?>



        </div>

    </body>
</html>
<?php
    include("classes/autoload.php");


    $login = new Login();
    $user_data = $login->check_login($_SESSION['hobbies_userid']);

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);
        if (is_array($profile_data)) {
            $user_data = $profile_data[0];
        }
    }





    //posting posts
    if($_SERVER['REQUEST_METHOD'] == "POST") {
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

    //getting posts
    $id = $user_data['userid'];
    $post = new Post();
    $posts = $post->get_post($id);

    //getting friends
    $user = new User();
    $friends = $user->get_friends($id);

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
                    <a href="change_profile_image.php?change=profile" style="text-decoration: none; color: #999999"> Change Profile Image</a> |
                    <a href="change_profile_image.php?change=cover" style="text-decoration: none; color: #999999"> Change Cover</a>

                </span>
                <br>
                <div style="font-size: 22px"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></div>
                <br>
                <a href="index.php"><div id="menu_buttons">Timeline</div></a>
                <div id="menu_buttons">About</div>
                <div id="menu_buttons">Hobbies</div>
                <div id="menu_buttons">Photos</div>
                <div id="menu_buttons">Settings</div>
            </div>

            <div style="display: flex">
                <div style="min-height: 400px; flex: 1">
                    <div id="hobbies_bar">
                        Hobbies<br>

                        <?php

                        if ($friends) {
                            foreach ($friends as $FRIEND_ROW) {

                                include("user.php");
                            }
                        }


                        ?>

                    </div>

                </div>



                <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0">
                    <div style=" padding: 10px; background-color: white">
                        <form method="post" enctype="multipart/form-data">
                            <textarea name="post" placeholder="What's on your mind?"></textarea>
                            <input type="file" name="file">
                            <input type="submit" id="post_button" value="Post">
                            <br>
                        </form>

                    </div>

                    <div id="post_bar">

                        <?php

                            if ($posts) {
                                foreach ($posts as $ROW) {
                                    $user = new User();
                                    $ROW_USER = $user->get_user($ROW['userid']);
                                    include("post.php");
                                }
                            }


                        ?>


                    </div>


                </div>

            </div>

        </div>

    </body>
</html>
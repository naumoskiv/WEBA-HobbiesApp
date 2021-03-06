<?php

    include("classes/autoload.php");


    $login = new Login();
    $image_class = new Image();
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
        $id = $_SESSION['hobbies_userid'];
        $post = new Post();
        $result = $post->create_post($id, $_POST, $_FILES);

        if($result == "") {
            header("Location: index.php");
        }
        else {
            echo "<div>";
            echo "The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hobbies App - Timeline</title>
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
            <div style="min-height: 400px; flex: 1">

                <div id="me_bar">
                    <?php

                    $image = "images/user_male.jpg";
                    if ($user_data['gender'] == "Female") {
                        $image = "images/user_female.jpg";
                    }
                    if (file_exists($user_data['profile_image'])) {
                        $image = $image_class->get_thumbnail_profile($user_data['profile_image']);

                    }
                    ?>
                    <img src="<?php echo $image; ?>" id="profile_photo">
                    <br>
                    <a href="profile.php" style="text-decoration: none"><?php echo $user_data['first_name'] . "<br>" . $user_data['last_name']; ?></a>
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
                    <br>
                </div>

                <div id="post_bar">

                    <?php

                        $DB = new Database();
                        $user_class = new User();
                        $followers = $user_class->get_following($_SESSION['hobbies_userid'], "user");
                        $follower_ids = false;

                        if (is_array($followers)) {
                            $follower_ids = array_column($followers, "userid");
                            $follower_ids = implode("','", $follower_ids);
                        }
                        if ($follower_ids) {
                            $myuserid = $_SESSION['hobbies_userid'];
                            $sql = "select * from posts where parent = 0 and userid = '$myuserid' || userid in('" . $follower_ids . "') order by id desc limit 30 ";
                            $posts = $DB->read($sql);
                        }

                        if (isset($posts) && $posts) {
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
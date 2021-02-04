<?php

    include("classes/autoload.php");


    $login = new Login();
    $image_class = new Image();
    $Post = new Post();
    $DB = new Database();

    $user_data = $login->check_login($_SESSION['hobbies_userid']);

    if (isset($_GET['find'])) {
        
        $find = addslashes($_GET['find']);

        $sql = "select * from users where first_name like '%$find%' || last_name like '%$find%' limit 10";
        $DB = new Database();
        $results = $DB->read($sql);
    }


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hobbies App - Likes</title>
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

                    <?php

                        $User = new User();
                        $image_class = new Image();

                        if (is_array($results)) {
                            foreach ($results as $row) {
                                $FRIEND_ROW = $User->get_user($row['userid']);
                                include("user.php");
                            }
                        }
                        else {
                            echo "No results were found";
                        }
                    ?>
                    <br style="clear: both">
                </div>

            </div>

        </div>

    </div>

    </body>
</html>
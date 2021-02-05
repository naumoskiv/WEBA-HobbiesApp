<div style="display: flex">
    <div style="min-height: 400px; flex: 1">
        <div id="hobbies_bar">
            Following<br>

            <?php

            if ($friends) {
                foreach ($friends as $friend) {
                    $user = new User();
                    $FRIEND_ROW = $user->get_user($friend['userid']);
                    include("user.php");
                }
            }


            ?>

        </div>

    </div>




    <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0">
        <?php
        if ($user_data['userid'] == $_SESSION['hobbies_userid']) {
            echo '<div style=" padding: 10px; background-color: white">';
            echo '<form method="post" enctype="multipart/form-data">';
            echo '<textarea name="post" placeholder="What\'s on your mind?"></textarea>';
            echo '<input type="file" name="file">';
            echo '<input type="submit" id="post_button" value="Post">';
            echo '<br>';
            echo '</form>';
            echo '</div>';
        }

        ?>

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
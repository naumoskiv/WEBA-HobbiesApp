<div id="post" style="background-color: #EEEEEE; border-radius: 10px">
    <div >
        <?php
            $image = "images/user_male.jpg";
            if ($ROW_USER['gender'] == "Female") {
                $image = "images/user_female.jpg";
            }
            if (file_exists($ROW_USER['profile_image'])) {
                $image_class = new Image();
                $image = $image_class->get_thumbnail_profile($ROW_USER['profile_image']);
            }

        ?>
        <img src="<?php echo $image ?>" style="width: 55px; margin-right: 5px; border-radius: 50%">
    </div>
    <div style="width: 100%">
        <div style="font-weight: bold">
            <?php
            echo "<a href='profile.php?id=$COMMENT[userid]'>";
            echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']);
            echo "</a>";
            if ($COMMENT['is_profile_image']) {
                $pronoun = "his";
                if ($ROW_USER['gender'] == "Female") {
                    $pronoun = "her";
                }
                echo "<span style='font-weight: lighter; color: #aaaaaa'> has changed $pronoun profile picture. </span>";
            }

            if ($COMMENT['is_cover_image']) {
                $pronoun = "his";
                if ($ROW_USER['gender'] == "Female") {
                    $pronoun = "her";
                }
                echo "<span style='font-weight: lighter; color: #aaaaaa'> has changed $pronoun cover picture. </span>";
            }

            ?>
        </div>
        <?php echo htmlspecialchars($COMMENT['post']); ?>
        <br><br>
        <?php
            if (file_exists($COMMENT['image'])) {
                $post_image = $image_class->get_thumbnail_post($COMMENT['image']);
                echo "<img src='$post_image' style='width: 100%'/>";
            }

        ?>
        <br>
        <br>
        <?php
            $likes = "";
            $likes = ($COMMENT['likes'] > 0) ? "(" . $COMMENT['likes'] . ")" : "";
        ?>
        <a href="like.php?type=post&id=<?php echo $COMMENT['postid']; ?>">Like <?php echo $likes; ?></a> |
        <span style="color: #999">
            <?php
            $time = new Time();
            echo $time->get_time($COMMENT['date']);
            ?>
        </span>

        <?php
            if ($COMMENT['has_image']) {
                echo " |<a href='image_view.php?id=$COMMENT[postid]'>View full image</a> |";
            }
        ?>

        <span style="color: #999; float: right">
            <?php
                $post = new Post();
                if ($post->i_own_post($COMMENT['postid'], $_SESSION['hobbies_userid'])) {
                    echo "<a href='edit.php?id=$COMMENT[postid]' style='color: #999999; text-decoration: none'>
                    Edit
                </a>
                |
                <a href='delete.php?id=$COMMENT[postid]' style='color: #999999; text-decoration: none'>
                    Delete
                </a>";
                }

            ?>

        </span>

        <?php

            $i_liked = false;

            if (isset($_SESSION['hobbies_userid'])) {

                $DB = new Database();
                $sql = "select likes from likes where type = 'post' && contentid = '$COMMENT[postid]' limit 1";
                $result = $DB->read($sql);

                if (is_array($result)) {
                    $likes = json_decode($result[0]['likes'], true);

                    $user_ids = array_column($likes, "userid");
                    if (in_array($_SESSION['hobbies_userid'], $user_ids)) {
                        $i_liked = true;
                    }
                }

                if($COMMENT['likes'] > 0) {
                    echo "<br>";
                    echo "<a href='likes.php?type=post&id=$COMMENT[postid]'";
                    if ($COMMENT['likes'] == 1) {
                        if ($i_liked) {
                            echo "<span style='float: left;'> You liked this comment</span>";
                        }
                        else {
                            echo "<span style='float: left;'> One person liked this comment</span>";
                        }
                    }
                    else {
                        if ($i_liked) {
                            $how_many = "others";
                            if ($COMMENT['likes'] - 1 == 1) {
                                $how_many = "other";
                            }
                            echo "<span style='float: left;'> You and " . ($COMMENT['likes'] - 1) . " " . $how_many . " liked this comment</span>";
                        }
                        else {
                            echo "<span style='float: left;'>" . $COMMENT['likes'] . " people liked this comment</span>";
                        }

                        echo "</a>";


                    }

                }
            }


        ?>
    </div>
</div>

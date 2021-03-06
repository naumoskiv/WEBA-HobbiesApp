<div id="post">
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
            echo "<a href='profile.php?id=$ROW[userid]'>";
            echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']);
            echo "</a>";
            if ($ROW['is_profile_image']) {
                $pronoun = "his";
                if ($ROW_USER['gender'] == "Female") {
                    $pronoun = "her";
                }
                echo "<span style='font-weight: lighter; color: #aaaaaa'> has changed $pronoun profile picture. </span>";
            }

            if ($ROW['is_cover_image']) {
                $pronoun = "his";
                if ($ROW_USER['gender'] == "Female") {
                    $pronoun = "her";
                }
                echo "<span style='font-weight: lighter; color: #aaaaaa'> has changed $pronoun cover picture. </span>";
            }

            ?>
        </div>
        <?php echo htmlspecialchars($ROW['post']); ?>
        <br><br>
        <?php
            if (file_exists($ROW['image'])) {
                $post_image = $image_class->get_thumbnail_post($ROW['image']);
                echo "<img src='$post_image' style='width: 100%'/>";
            }

        ?>
        <br>
        <br>
        <?php
            $likes = "";
            $likes = ($ROW['likes'] > 0) ? "(" . $ROW['likes'] . ")" : "";
        ?>
        <a href="like.php?type=post&id=<?php echo $ROW['postid']; ?>">Like <?php echo $likes; ?></a> |

        <?php
            $comments = "";

            if ($ROW['comments'] > 0) {
                $comments = "(" . $ROW['comments'] . ")";
            }
        ?>

        <a href="single_post.php?id=<?php echo $ROW['postid']; ?>">Comment<?php echo $comments; ?></a> |
        <span style="color: #999">
            <?php
            $time = new Time();
            echo $time->get_time($ROW['date']);
            ?>
        </span>

        <?php
            if ($ROW['has_image']) {
                echo " |<a href='image_view.php?id=$ROW[postid]'> View full image</a> |";
            }
        ?>

        <span style="color: #999; float: right">
            <?php
                $post = new Post();
                if ($post->i_own_post($ROW['postid'], $_SESSION['hobbies_userid'])) {
                    echo "<a href='edit.php?id=$ROW[postid]' style='color: #999999; text-decoration: none'>
                    Edit
                </a>
                |
                <a href='delete.php?id=$ROW[postid]' style='color: #999999; text-decoration: none'>
                    Delete
                </a>";
                }

            ?>

        </span>

        <?php

            $i_liked = false;

            if (isset($_SESSION['hobbies_userid'])) {

                $DB = new Database();
                $sql = "select likes from likes where type = 'post' && contentid = '$ROW[postid]' limit 1";
                $result = $DB->read($sql);

                if (is_array($result)) {
                    $likes = json_decode($result[0]['likes'], true);

                    $user_ids = array_column($likes, "userid");
                    if (in_array($_SESSION['hobbies_userid'], $user_ids)) {
                        $i_liked = true;
                    }
                }

                if($ROW['likes'] > 0) {
                    echo "<br>";
                    echo "<a href='likes.php?type=post&id=$ROW[postid]'";
                    if ($ROW['likes'] == 1) {
                        if ($i_liked) {
                            echo "<span style='float: left;'> You liked this post.</span>";
                        }
                        else {
                            echo "<span style='float: left;'> One person liked this post.</span>";
                        }
                    }
                    else {
                        if ($i_liked) {
                            $how_many = "others";
                            if ($ROW['likes'] - 1 == 1) {
                                $how_many = "other";
                            }
                            echo "<span style='float: left;'> You and " . ($ROW['likes'] - 1) . " " . $how_many . " liked this post.</span>";
                        }
                        else {
                            echo "<span style='float: left;'>" . $ROW['likes'] . " people liked this post.</span>";
                        }

                        echo "</a>";


                    }

                }
            }


        ?>
    </div>
</div>

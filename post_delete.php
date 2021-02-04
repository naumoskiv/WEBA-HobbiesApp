<div id="post">
    <div >
        <?php
            $image_class = new Image();
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
            <?php echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']);
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

        <span style="color: #999">
            <?php echo $ROW['date']; ?>
        </span>

    </div>
</div>

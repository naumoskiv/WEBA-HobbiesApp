<div id="hobbies">
    <?php
        $image = "images/user_male.jpg";
        if ($FRIEND_ROW['gender'] == "Female") {
            $image = "images/user_female.jpg";
        }
        if (file_exists($FRIEND_ROW['profile_image'])) {
            $image_class = new Image();
            $image = $image_class->get_thumbnail_profile($FRIEND_ROW['profile_image']);
        }
    ?>
    <a href="profile.php?id=<?php echo $FRIEND_ROW['userid']; ?>">
        <img id="hobby_image" src="<?php echo $image; ?>"> <br>
        <?php echo $FRIEND_ROW['first_name'] . " " . $FRIEND_ROW['last_name']; ?>
    </a>

</div>
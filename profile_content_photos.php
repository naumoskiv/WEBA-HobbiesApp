<div style="min-height: 400px; width: 100%; background-color: white; text-align: center">
    <div style="padding: 20px">

    <?php

        $DB = new Database();
        $images_class = new Image();
        $sql = "select image, postid from posts where has_image = 1 && userid = $user_data[userid] order by id desc limit 30";
        $images = $DB->read($sql);

        if (is_array($images)) {
            foreach ($images as $image_row) {
                echo "<a href='single_post.php?id=$image_row[postid]'>";
                echo "<img src='" . $images_class->get_thumbnail_post($image_row['image']) . "' style='width: 150px; margin: 10px;' />";
                echo "</a>";
            }

        }
        else {
            echo "No images were found";
        }


    ?>
    </div>
</div>

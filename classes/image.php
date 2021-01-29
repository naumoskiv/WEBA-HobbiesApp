<?php

class Image {

    public function crop_image($original_file_name, $cropped_file_name, $width, $height) {
        if (file_exists($original_file_name)) {
            $original_image = imagecreatefromjpeg($original_file_name);
            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            if ($original_height > $original_width) {
                $ratio = $width / $original_width;
                $new_width = $width;
                $new_height = $original_height * $ratio;
            }
            else {
                $ratio = $height / $original_height;
                $new_height = $height;
                $new_width = $original_width * $ratio;
            }
        }

        //adjust if width and height are not equal
        if ($width != $height) {
            if ($height > $width) {
                if ($height > $new_height) {
                    $adjustment = ($height / $new_height);
                }
                else {
                    $adjustment = ($new_height / $height);
                }
                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }
            else {
                if ($width > $new_width) {
                    $adjustment = ($width / $new_width);
                }
                else {
                    $adjustment = ($new_width / $width);
                }
                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        imagedestroy($original_image);

        if($width != $height) {
            if($width > $height) {
                $diff = ($new_height - $height);
                if ($diff < 0) {
                    $diff = $diff * -1;
                }
                $y = round($diff / 2);
                $x = 0;
            }
            else {
                $diff = ($new_width - $height);
                if ($diff < 0) {
                    $diff = $diff * -1;
                }
                $x = round($diff / 2);
                $y = 0;
            }
        }
        else {
            if($new_height > $new_width) {
                $diff = ($new_height - $new_width);
                $y = round($diff / 2);
                $x = 0;
            }
            else {
                $diff = ($new_width - $new_height);
                $x = round($diff / 2);
                $y = 0;
            }
        }


        $new_cropped_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_cropped_image, $new_image, 0, 0, $x, $y, $width, $height, $width, $height);
        imagedestroy($new_image);
        imagejpeg($new_cropped_image, $cropped_file_name, 90 );
        imagedestroy($new_cropped_image);
    }

    public function generate_filename($length) {
        $array = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
             'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $text = "";

        for ($i=0; $i<$length; $i++) {
            $random = rand(0, 61);
            $text .= $array[$random];
        }

        return $text;
    }

    //resize image only, do not crop
    public function resize_image($original_file_name, $resized_file_name, $width, $height) {
        if (file_exists($original_file_name)) {
            $original_image = imagecreatefromjpeg($original_file_name);
            $original_width = imagesx($original_image);
            $original_height = imagesy($original_image);

            if ($original_height > $original_width) {
                $ratio = $width / $original_width;
                $new_width = $width;
                $new_height = $original_height * $ratio;
            }
            else {
                $ratio = $height / $original_height;
                $new_height = $height;
                $new_width = $original_width * $ratio;
            }
        }

        //adjust if width and height are not equal
        if ($width != $height) {
            if ($height > $width) {
                if ($height > $new_height) {
                    $adjustment = ($height / $new_height);
                }
                else {
                    $adjustment = ($new_height / $height);
                }
                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }
            else {
                if ($width > $new_width) {
                    $adjustment = ($width / $new_width);
                }
                else {
                    $adjustment = ($new_width / $width);
                }
                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }
        }

        $new_image = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        imagedestroy($original_image);


        imagejpeg($new_image, $resized_file_name, 90 );
        imagedestroy($new_image);
    }

    public function get_thumbnail_cover($filename) {
        $thumbnail = $filename . "_cover_thumbnail.jpg";

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }
        $this->crop_image($filename, $thumbnail, 1366, 488);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }
        else {
            return $filename;
        }
    }

    public function get_thumbnail_profile($filename) {
        $thumbnail = $filename . "_profile_thumbnail.jpg";

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }
        $this->crop_image($filename, $thumbnail, 600, 600);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }
        else {
            return $filename;
        }
    }

    public function get_thumbnail_post($filename) {
        $thumbnail = $filename . "_post_thumbnail.jpg";

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }
        $this->crop_image($filename, $thumbnail, 600, 600);

        if (file_exists($thumbnail)) {
            return $thumbnail;
        }
        else {
            return $filename;
        }
    }
}
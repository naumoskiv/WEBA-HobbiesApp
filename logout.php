<?php
    session_start();

    if(isset($_SESSION['hobbies_userid'])) {
        $_SESSION['hobbies_userid'] = NULL;
        unset($_SESSION['hobbies_userid']);
    }

    header("Location: login.php");
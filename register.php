<?php

    include("classes/connect.php");
    include("classes/signup.php");

    $first_name = "";
    $last_name = "";
    $gender = "";
    $email = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $signup = new SignUp();
        $result = $signup->evaluate($_POST);

        if ($result != "") {
            echo "<div>";
            echo "The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }
        else {
            header("Location: login.php");
            die;
        }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];

    }

?>









<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Hobbies App - Register</title>
    </head>

    <style>
        #bar{
            height: 100px;
            background-color: cadetblue;
            color: white;
            padding: 5px;
        }
        #signup_button{
            background-color: whitesmoke;
            width: 80px;
            text-align: center;
            padding: 5px;
            border-radius: 5px;
            color: cadetblue;
            float: right;
        }
        #login_form{
            background-color: white;
            width: 800px;
            height: auto;
            margin: 40px auto auto;
            padding: 40px 10px 10px;
            text-align: center;
        }
        #text{
            height: 40px;
            width: 300px;
            border-radius: 5px;
            border: solid 1px #aaa;
            padding: 5px;
            font-size: 15px;
        }
        #login_button{
            height: 40px;
            width: 300px;
            border-radius: 5px;
            font-weight: bold;
            border: none;

        }
    </style>

    <body style="font-family: Tahoma,serif; background-color: whitesmoke">
    <div id="bar">
        <div style="font-size: 40px">Hobbies</div>
        <a href="login.php">
            <div id="signup_button">Log In</div>
        </a>

    </div>

    <div id="login_form">
        Register to Hobbies App <br><br>

        <form method="post" action="">

            <input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="First Name"> <br><br>
            <input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Last Name"> <br><br>
            <select id="text" name="gender">
                <option><?php echo $gender ?></option>
                <option>Male</option>
                <option>Female</option>
            </select> <br><br>
            <input value="<?php echo $email ?>" name="email" type="text" id="text" placeholder="Email"> <br><br>
            <input name="password" type="password" id="text" placeholder="Password"> <br><br>
            <input name="password_cnf" type="password" id="text" placeholder="Confirm Password"> <br><br>
            <input type="submit" id="login_button" value="Register">

        </form>

    </div>
    </body>
</html>
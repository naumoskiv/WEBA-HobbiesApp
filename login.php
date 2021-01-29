<?php

    include("classes/autoload.php");

    $email = "";
    $password = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $login = new Login();
        $result = $login->evaluate($_POST);

        if ($result != "") {
            echo "<div>";
            echo "The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }
        else {
            header("Location: profile.php");
            die;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

    }




?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hobbies App - Log In</title>
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
            height: 300px;
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
            <div id="signup_button">Register</div>
        </div>

        <div id="login_form">

            <form method="post">
                Log in to Hobbies App <br><br>
                <input name="email" value="<?php echo $email?>" type="text" id="text" placeholder="Email"> <br><br>
                <input name="password" value="<?php echo $password?>" type="password" id="text" placeholder="Password"> <br><br>
                <input type="submit" id="login_button" value="Log In">
            </form>

        </div>
    </body>
</html>
<?php

class SignUp {

    private $error = "";

    public function evaluate($data) {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->error .= $key . " is empty!<br>";
            }
            if ($key == "email") {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->error .= "Invalid email format<br>";
                }
            }
            if ($key == "first_name") {
                if (!preg_match("/^[a-zA-Z-' ]*$/",$value)) {
                    $this->error = "Only letters and white space allowed<br>";
                }
            }
            if ($key == "last_name") {
                if (!preg_match("/^[a-zA-Z-' ]*$/",$value)) {
                    $this->error = "Only letters and white space allowed<br>";
                }
            }
            if ($key == "password") {
                if (strlen($value) < 8) {
                    $this->error = "Password must have at least 8 characters<br>";
                }
            }

        }

        if($this->error == "") {
            $this->createUser($data);
        }
        else {
            return $this->error;
        }
    }

    public function createUser($data) {
        $first_name = ucfirst($data['first_name']);
        $last_name = ucfirst($data['last_name']);
        $gender = $data['gender'];
        $email = $data['email'];
        $password = $data['password'];

        //create these
        $userid = $this->create_userid();
        $url_address = strtolower($first_name) . "." . strtolower($last_name);

        $query = "insert into users (userid, first_name, last_name, gender, email, password, url_address) values ('$userid', '$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";

        $DB = new Database();
        $DB->save($query);
    }

    private function create_userid() {
        $length = rand(4, 19);
        $number = "";
        for ($i=1; $i<$length; $i++) {
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }
        return $number;
    }
}
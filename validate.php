<?php
$name_err = $email_err = $mobile_err = $dob_err = "";
$name = $email = $mobile = $date = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $name_err = "name is required";
    } else {
        $name = test_input($_POST["username"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $name_err = "Only letters and white space allowed";
        }
    }
    if (empty($_POST['email'])) {
        $email_err = "email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }
    }
    $mobile = test_input($_POST['mobile']);
    if (!preg_match('/^[0-9]{10}+$/', $mobile)) {
        $mobile_err = "please enter a valid phone number";
    }
    if (empty($_POST["dob"])) {
        $dob_err = "please enter a valid date";
    } else {
        $date = $_POST["dob"];
    }
    $show_alert = false;
    if ($name_err == "" && $email_err == "" && $mobile_err == "" && $dob_err == "") {
        $sql = "INSERT INTO `user_info` (`name`, `email`, `mobile`, `DOB`) VALUES ('$name', '$email', '$mobile', '$date')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            session_start();
            $_SESSION['username'] = $name;
            header('Location: welcome.php');
            exit();
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<?php

function validate_input($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = filter_var($input, 513);

    return $input;
}

function validate_email($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return $email;
}

function nospecial_char($input)
{
    if (preg_match('/[\'^£$%!.&*()}{@#~?><>,|=_+¬-]/', $input)) {
        return false;
    } else {
        return true;
    }
}

function notEmpty($input)
{
    if (!isset($input) || trim($input) == '') {
        return false;
    } else {
        return true;
    }
}

function validEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return true;
      } else {
        return false;
      }
}

function validPassword($pass)
{
    if ((strlen($pass) < 8 || strlen($pass) > 16) && (!preg_match("/\d/", $pass)) && (!preg_match("/[A-Z]/", $pass)) && (!preg_match("/[a-z]/", $pass)) && (!preg_match("/\W/", $pass)) && (preg_match("/\s/", $pass))) {
        return false;
    } else {
        return true;
    }
}

?>

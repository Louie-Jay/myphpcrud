<!DOCTYPE html>
<html>

<head>
    <?php require "components/stylescripts.php"; ?>
    <title>Registration</title>
</head>

<body>

    <div class="position-absolute top-50 start-50 translate-middle mt-3">
        <?php


        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['regbtn'])) {
            require_once "components/validator.php";

            $firstname = $_POST['regfname'];
            $lastname = $_POST['reglname'];
            $email = $_POST['regemail'];
            $password = $_POST['regpassword'];
            $valid = false;

            if (notEmpty($firstname)) {
                if (nospecial_char($firstname)) {
                    $firstname = validate_input($firstname);
                    $valid = true;

                } else {
                    $valid = false;
                    echo "<div class='alert alert-dismissible alert-danger'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Register failed!</strong> First name must <u>not contain special characters</u> only space is allowed.
          </div>";
                }
            } else {
                $valid = false;
                echo "<div class='alert alert-dismissible alert-danger'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Register failed!</strong> First Name cannot be <u>empty</u>.
              </div>";
            }

            if (notEmpty($lastname)) {
                if (nospecial_char($lastname)) {
                    $lastname = validate_input($lastname);
                    $valid = true;

                } else {
                    echo "<div class='alert alert-dismissible alert-danger'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Register failed!</strong> Last name must <u>not contain special characters</u> only space is allowed.
          </div>";
                }
            } else {
                $valid = false;
                echo "<div class='alert alert-dismissible alert-danger'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Register failed!</strong> Last Name cannot be <u>empty</u>.
              </div>";
            }

            if (notEmpty($email)) {
                if (validEmail($email)) {
                    $email = validate_email($email);
                    $valid = true;

                } else {
                    $valid = false;
                    echo "<div class='alert alert-dismissible alert-danger'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Register failed!</strong> Email address <u>not valid.</u>.
          </div>";
                }
            } else {
                $valid = false;
                echo "<div class='alert alert-dismissible alert-danger'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Register failed!</strong> Email cannot be <u>empty</u>.
              </div>";
            }

            if (notEmpty($password)) {
                if (validPassword($password)) {
                    $password = validate_input($password);

                    $password = password_hash($password, PASSWORD_DEFAULT);

                    $valid = true;

                } else {
                    $valid = false;
                    echo "<div class='alert alert-dismissible alert-danger'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Register failed!</strong> Password must have <u>8-16 letters, at least 1 digit, capital, lower, special</u> and does <u>not contain space </u>.
          </div>";
                }
            } else {
                $valid = false;
                echo "<div class='alert alert-dismissible alert-danger'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Register failed!</strong> Password cannot be <u>empty</u>.
              </div>";
            }

            if ($valid) {
                try {
                    include_once "database/database.php";
                    $db = new Database();
                    $db->openDatabase();


                    $sql = "INSERT INTO admins (firstname, lastname, email, password)
                VALUES ('$firstname', '$lastname', '$email', '$password')";

                    $db->stmtExecute($sql);
                    $db->closeDatabase();

                    echo "<div class='alert alert-dismissible alert-success'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Success!</strong> $email has been <u class='alert-link'>successfully registered</u>.
                  </div>";
                } catch (PDOException $ex) {
                    echo "<div class='alert alert-dismissible alert-primary'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Oh snap!</strong> <u>Something snapped.. </u> try again later.
              </div>";
                    $db->closeDatabase();
                }
            }
        }
        ?>
        <div class="card border-primary mb-3">
            <div class="card-body">
                <h4 class="card-title text-center">Registration</h4>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-floating mb-1 mt-3">
                        <input type="text" class="form-control" id="floatingfname" placeholder="First Name" name="regfname" required>
                        <label for="floatingfname">First Name</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="text" class="form-control" id="floatinglname" placeholder="Last Name" name="reglname" required>
                        <label for="floatinglname">Last Name</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="email" class="form-control" id="floatingemail" placeholder="Email" name="regemail" required>
                        <label for="floatingemail">Email address</label>
                    </div>
                    <div class="form-floating mb-1">
                        <input type="password" class="form-control" id="floatingpassword" placeholder="Password" name="regpassword" required>
                        <label for="floatingpassword">Password</label>
                    </div>

                    <div class="container mt-3 ps-0 pe-0">
                        <div class="row">
                            <div class="col-3 text-lg-start">
                                <input type="submit" value="Register" class="btn btn-primary" name="regbtn">
                            </div>
                            <div class="col-9 text-lg-end">
                                <a href="index.php" class="btn btn-link" role="button"> Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>

</html>
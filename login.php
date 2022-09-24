<div class="container position-absolute top-50 start-50 translate-middle w-25">
    <?php
    if (isset($_POST['loginbtn']) && $_SERVER["REQUEST_METHOD"] = "POST") {

        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            try {
                include_once "database/database.php";
                $db = new Database();
                $db->openDatabase();
                $db->stmtExecute("SELECT firstname, lastname, email, password FROM admins WHERE email='$email'");

                if ($db->getAssocResult() == false) {
                    echo "
                    <div class='alert alert-dismissible alert-warning'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Email not found.</strong> <u>Register </u>first then try again.
          </div>
                    ";
                    $db->closeDatabase();
                    $db = null;
                } else {


                    if ($db->getAssocResult()[0]['email'] == $_POST['email'] && password_verify(($_POST['password']), ($db->getAssocResult()[0]['password']))) {
                        session_start();

                        $_SESSION['userfname'] = $db->getAssocResult()[0]['firstname'];
                        $_SESSION['userlname'] = $db->getAssocResult()[0]['lastname'];
                        $db->closeDatabase();
                        header("Location: dashboard.php");
                    } else {
                        echo "<div class='alert alert-dismissible alert-danger'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Login failed!</strong> <u>Wrong password</u> or email.
          </div>";
                    }
                }
            } catch (PDOException $ex) {
                echo "<div class='alert alert-dismissible alert-danger'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Oh snap!</strong> <u>Something snapped,</u> try again later.
          </div>";
                $db->closeDatabase();
            }
        } else {
            echo "<div class='alert alert-dismissible alert-danger'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Login failed!</strong> <u>Invalid email address</u>, input proper email address.
          </div>";
        }
    }

    ?>
    <div class="card border-primary mb-3">
        <div class="card-header text-center">Login</div>
        <div class="card-body">
            <h4 class="card-title text-center">Welcome!</h4>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label mt-2">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                </div>

                <div class="container mt-1 p-0">
                    <div class="row">
                        <div class="col text-lg-start">
                            <input class="btn btn-primary" type="submit" value="Login" name="loginbtn">
                        </div>
                        <div class="col text-lg-end">
                            <a href="register.php" class="btn btn-secondary" role="button"> Register</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
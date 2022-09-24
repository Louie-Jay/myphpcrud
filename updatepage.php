<?php
session_start();
?>

<!DOCTYPE html>

<?php

$fname = $lname = $addr = $deposit = "";
$valid = false;


require "components/validator.php";

?>
<html>

<head>
    <?php require "components/stylescripts.php"; ?>
</head>

<body>
    <?php require "components/navbar.php"; ?>

    <div class="container-lg align-middle mt-lg-2">
        <p> PHP Update (to Database) showcase</p>

        <?php

        // if (isset($_POST['updaterow'])) {
        //     echo $_POST['up_id'];
        //     $id = $_POST['up_id'];
        //     echo $_POST['up_firstname'];
        // } else {
        //     echo "not set";
        // }

        if (isset($_POST['updateform']) || $_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['id'])) {
                // echo "Selected ID: ". $_POST['id'];
                $upid = validate_input($_POST['id']);

                $fnameerr = $lnameerr = $addrerr = $depositerr = "";

                if (isset($_POST['firstname'])) {
                    if (empty($_POST['firstname']) && trim($_POST['firstname']) == "") {
                        $fnameerr = "Cannot be empty";
                    } else {
                        $fname = validate_input($_POST['firstname']);
                        $fnameerr = "";
                    }
                } else {
                    $fnameerr = "Invalid input";
                }

                if (isset($_POST['lastname'])) {
                    if (empty($_POST['lastname']) && trim($_POST['lastname']) == "") {
                        $lnameerr = "Cannot be empty";
                    } else {
                        $lname = validate_input($_POST['lastname']);
                    }
                } else {
                    $lnameerr = "Invalid input";
                }

                if (isset($_POST['address'])) {
                    if (empty($_POST['address']) && trim($_POST['address']) == "") {
                        $addrerr = "Cannot be empty";
                    } else {
                        $addr = validate_input($_POST['address']);
                    }
                } else {
                    $addrerr = "Invalid input";
                }

                if (isset($_POST['deposit'])) {
                    if (empty($_POST['deposit']) && trim($_POST['deposit']) == "") {
                        $depositerr = "Cannot be empty";
                    } else {
                        $deposit = validate_input($_POST['deposit']);
                    }
                } else {
                    $depositerr = "Invalid input";
                }

                if ($fnameerr == "" && $lnameerr == "" && $addrerr == "" && $depositerr == "") {
                    // echo "All clear";
                    // echo $_POST['firstname'] . "<br>";
                    // echo $_POST['lastname'] . "<br>";
                    // echo $_POST['address'] . "<br>";
                    // echo $_POST['deposit'] . "<br>";

                    try {
                        $valid = true;
                        include_once "database/database.php";
                        $db = new Database();
                        $db->openDatabase();
                        $sql = "UPDATE clients SET firstname ='" . $fname . "', lastname ='" . $lname . "', address ='" . $addr . "', deposit ='" . $deposit . "' WHERE id ='" . $upid . "';";
                        $db->stmtExecute($sql);
                        $db->closeDatabase();
                        $db = null;
                        echo "<div class='alert alert-dismissible alert-success'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong>Success!</strong> $fname $lname has been <u class='alert-link'>successfully updated</u>.
                  </div>";
                    } catch (PDOException $ex) {
                        echo "<div class='alert alert-dismissible alert-primary'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Oh snap!</strong> <u>Something snapped.. </u> try again later.
                <p>" . $ex->getMessage() . "</p>
              </div>";
                    }
                } else {
                    $valid = false;
                    echo "<div class='alert alert-dismissible alert-primary'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Oh snap!</strong> <u>Invalid input, please change a few things up</u> and try submitting again.
              </div>";
                }
            } else {
                echo "<div class='alert alert-dismissible alert-warning'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Update failed!</strong> <u>Please select on the table first</u> and try submitting again.
              </div>";
            }
        }

        ?>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Update</h4>
                <h6 class="card-subtitle mb-2 text-muted">Update data to database</h6>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" name="formupdate">

                    <div class="d-grid">
                        <div class="row">
                            <input type='hidden' name='id' value="<?php echo (!isset($_POST['up_id'])) ? "" : $_POST['up_id'] ?>">
                            <div class="col form-group">
                                <label for="firstname" class="form-label mt-2">Firstname</label>
                                <input type="text" class="form-control" id="firstname" placeholder="Firstname" name="firstname" value="<?php echo (!isset($_POST['up_firstname'])) ? "" : $_POST['up_firstname'] ?>">
                            </div>
                            <div class="col form-group">
                                <label for="lastname" class="form-label mt-2">Lastname</label>
                                <input type="text" class="form-control" id="lastname" placeholder="Lastname" name="lastname" value="<?php echo (!isset($_POST['up_lastname'])) ? "" : $_POST['up_lastname'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col form-group">
                                <label for="address" class="form-label mt-2">Address</label>
                                <input type="text" class="form-control" id="address" placeholder="Address" name="address" value="<?php echo (!isset($_POST['up_address'])) ? "" : $_POST['up_address'] ?>">
                            </div>
                            <div class="col form-group">
                                <label class="form-label mt-2">Deposit</label>
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">$</span>
                                        <input type="number" min="0" class="form-control" aria-label="Amount (to the nearest dollar)" name="deposit" value="<?php echo (!isset($_POST['up_deposit'])) ? "" : $_POST['up_deposit'] ?>">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-25" name="updateform">Update</button>
                    </div>

                </form>
            </div>
        </div>

        <table class="table table-hover mt-1">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Address</th>
                    <th scope="col">Deposit</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include_once "database/database.php";
                $db = new Database();
                $db->openDatabase();

                $db->stmtExecute("SELECT * FROM clients");

                foreach ($db->getAssocResult() as $row => $cols) {
                    echo "
                <tr>
                <form action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post' name='formrow'>
                <th scope='row'> <input type='hidden' name='up_id' value='" . $cols['id'] . "'>" . $cols['id'] . "</th>
                <td> <input type='hidden' name='up_firstname' value='" . $cols['firstname'] . "'>" . $cols['firstname'] . "</td>
                <td><input type='hidden' name='up_lastname' value='" . $cols['lastname'] . "'>" . $cols['lastname'] . "</td>
                <td><input type='hidden'  name='up_address' value='" . $cols['address'] . "'>" . $cols['address'] . "</td>
                <td>$<input type='hidden' name='up_deposit' value=" . $cols['deposit'] . ">" . $cols['deposit'] . "</td>
                <td><button class='btn btn-info' type='submit' name='updaterow'> Select </button> </form> </td>
                </tr>
                ";
                }
                // ptrint_r($db->geAssocResult());
                $db->closeDatabase();

                ?>

            </tbody>
        </table>
    </div>
</body>

</html>
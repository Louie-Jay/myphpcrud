<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    include "components/stylescripts.php";
    ?>
</head>

<body>
    <?php
    include "components/navbar.php";
    ?>

    <div class="container-lg align-middle mt-lg-2">
        <?php

        if (isset($_POST['formdelete'])) {
            // echo "clicked";
            // echo $_POST['del_id'] . "<br>";
            // echo $_POST['del_firstname'] . "<br>";
            // echo $_POST['del_lastname'] . "<br>";

            try {
                include_once "components/validator.php";
                $id = validate_input($_POST['del_id']);
                include_once "database/database.php";
                $db = new Database();
                $db->openDatabase();
                $sql = "DELETE FROM clients WHERE id = '$id';";
                $db->stmtExecute($sql);
                $db->closeDatabase();
                $db = null;
                echo "<div class='alert alert-dismissible alert-success'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Success!</strong> " . $_POST['del_firstname'] . " " . $_POST['del_lastname'] . " has been <u class='alert-link'>successfully deleted in the database</u>.
            </div>";
            } catch (PDOException $ex) {
                echo "<div class='alert alert-dismissible alert-primary'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong>Oh snap!</strong> <u>Something snapped.. </u> try again later.
                <p>" . $ex->getMessage() . "</p>
            </div>";
            }
        }

        ?>
        <div class="card border-primary mb-3">
            <div class="card-header">Delete</div>
            <div class="card-body">
                <h4 class="card-title">Delete data in the database.</h4>
                <p class="card-text">Select and click delete on the action column to delete row data.</p>
                <table class="table table-hover">
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
                            <tr><form action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post' name='rowdelete'>
                            <th scope='row'> <input type='hidden' name='del_id' value='" . $cols['id'] . "'>" . $cols['id'] . "</th>
                            <td> <input type='hidden' name='del_firstname' value='" . $cols['firstname'] . "'>" . $cols['firstname'] . "</td>
                            <td><input type='hidden' name='del_lastname' value='" . $cols['lastname'] . "'>" . $cols['lastname'] . "</td>
                            <td><input type='hidden'  name='del_address' value='" . $cols['address'] . "'>" . $cols['address'] . "</td>
                            <td>$<input type='hidden' name='del_deposit' value=" . $cols['deposit'] . ">" . $cols['deposit'] . "</td>
                            <td><button type='submit' class='btn btn-danger' name='formdelete'>Delete</button></td>
                            </form>
                        </tr>";
                        }
                        // print_r($db->getAssocResult());
                        $db->closeDatabase();
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
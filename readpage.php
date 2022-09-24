<?php
session_start();
?>

<!DOCTYPE html>
<?php

$selectedsearch = $_GET['searchcolumn'];

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $selectedsearch = $_GET['searchcolumn'];
    //setcookie();
}



?>
<html>

<head>
    <?php
    require "components/stylescripts.php";
    ?>
</head>

<body>
    <?php
    require "components/navbar.php";
    include "components/validator.php";
    ?>


    <div class="container-lg align-middle mt-lg-2">
        <div class="card border-primary">
            <div class="card-header">Read/Search</div>
            <div class="card-body">
                <h4 class="card-title">Read/Search in database</h4>
                <p class="card-text">PHP Read & "Search" (to Database) showcase</p>

                <div class="d-grid">
                    <div class="row">
                        <div class="col-2">
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?searchcolumn=$selectedsearch"; ?>" method="get">
                                <div class="btn-group w-100" role="group" aria-label="Button group with nested dropdown">
                                    <button type="button" class="btn btn-primary" name="searchcolumn"><?php echo strtoupper($selectedsearch); ?></button>
                                    <div class="btn-group w-100" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <button type="submit" class="dropdown-item" name="searchcolumn" value="id">ID</button>
                                            <button type="submit" class="dropdown-item" name="searchcolumn" value="firstname">First Name</button>
                                            <button type="submit" class="dropdown-item" name="searchcolumn" value="lastname">Last Name</button>
                                            <button type="submit" class="dropdown-item" name="searchcolumn" value="address">Address</button>
                                            <button type="submit" class="dropdown-item" name="searchcolumn" value="deposit">Deposit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-10">
                            <form class="d-flex" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . "?searchcolumn=$selectedsearch"; ?>" method="post">
                                <input class="form-control me-lg-1 w-100" type="text" placeholder="Search" name="searchinput">
                                <button class="btn btn-secondary my-2 my-sm-0" type="submit" name="searchbtn">Search</button>
                            </form>
                        </div>

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
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        if (isset($_POST['searchbtn']) || $_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_POST['searchinput'])) {
                                include "database/database.php";
                                $searchinput = $_POST['searchinput'];

                                $db = new Database();
                                $db->openDatabase();

                                $db->stmtExecute("SELECT * FROM clients WHERE ".validate_input($selectedsearch)." LIKE '%".validate_input($searchinput)."%';");
                                // echo "SELECT * FROM clients WHERE $selectedsearch = '$searchinput'"."<br>";

                                foreach ($db->getAssocResult() as $row => $cols) {
                                    echo "
                                        <tr>
                                        <th scope='row'>" . $cols['id'] . "</th>
                                        <td>" . $cols['firstname'] . "</td>
                                        <td>" . $cols['lastname'] . "</td>
                                        <td>" . $cols['address'] . "</td>
                                        <td>$" . $cols['deposit'] . "</td>
                                        
                                    </tr>
                                        ";
                                }
                                // print_r($db->getAssocResult());
                                $db->closeDatabase();
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'> Search data to show... </td></tr>";
                        }

                        ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>


</body>

</html>
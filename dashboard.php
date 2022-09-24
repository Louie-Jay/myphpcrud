<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <?php require "components/stylescripts.php"; ?>
    <title>Dashboard CRUD</title>
</head>

<body>
    <?php
    require "components/navbar.php";
    ?>
    
    <div class="container-lg align-middle mt-lg-2">
    <p> Welcome to PHP CRUD (Create, Read, Update, Delete) simple showcase by Louie Jay Lomibao</p>
    <p> Pure PHP + Bootstrap + MySQL used, no frameworks and Javascript written in this site.</p>
    <p> Beta version, not 100% responsive yet and forgot password and verification to be followed...</p>
    <p> Current Database content: </p>
    <table class="table table-hover">
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

            
            include "database/database.php";
            $db = new Database();
            $db->openDatabase();
            $db->stmtExecute("SELECT * FROM clients");

            foreach($db->getAssocResult() as $row => $cols) {
                echo "
                <tr>
                <th scope='row'>".$cols['id']."</th>
                <td>".$cols['firstname']."</td>
                <td>".$cols['lastname']."</td>
                <td>".$cols['address']."</td>
                <td>$".$cols['deposit']."</td>
            </tr>
                ";
            }
            // print_r($db->getAssocResult());
            $db->closeDatabase();
            ?>
            
        </tbody>
    </table>
    </div>
    

</body>

</html>
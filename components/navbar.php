<?php

if ($_SERVER['REQUEST_METHOD'] = "POST" && isset($_POST['logoutbtn'])) {
    session_unset();
    session_destroy();
    
    header("Location: index.php");
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">PHP CRUD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <?php
            $parts = explode('/', $_SERVER["SCRIPT_NAME"]);
            $file = $parts[count($parts) - 1];
            ?>
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($file, "dashboard.php") !== false) ? "active" : ""; ?> " href="dashboard.php">Home
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($file, "createpage.php") !== false) ? "active" : ""; ?>" href="createpage.php">Create</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($file, "readpage.php") !== false) ? "active" : ""; ?>" href="readpage.php?searchcolumn=id">Read</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($file, "updatepage.php") !== false) ? "active" : ""; ?>" href="updatepage.php">Update</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (strpos($file, "deletepage.php") !== false) ? "active" : ""; ?>" href="deletepage.php">Delete</a>
                </li>
            </ul>

            <div class="d-flex ">
                <div class="row">
                    <div class="col text-center flex-nowrap"><span>Welcome, <?php echo $_SESSION['userfname']." ".$_SESSION['userlname'] ?></span></div>
                    <div class="col text-end"><form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> <button class="btn btn-secondary " type="submit" name="logoutbtn">Logout</button> </form></div>
                </div>
            </div>
        </div>
    </div>
</nav>
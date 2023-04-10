<?php

include 'classAutoloader.php';

$residentManager = new ResidentManager();
$loginManagement = new LoginManagement();
$authentification = new Authentification();

$loginManagement->startSession();

if ($loginManagement->checkIfLoggedIn() == false) {
    header("Location: ./login.php");
}
if ($authentification->authApplicationProcessing() == false) {
    header("Location: ./dashboard.php");
}

$tableData = $residentManager->displayResidents();
$filter = 'all';

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['filter'])){
        if($_GET['filter'] == "all"){
            $tableData = $displayResidents->displayResidents();
            $filter = 'all';
        }
        if($_GET['filter'] == "accepted"){
            $tableData = $residentManager->displayResidentByPosition("Resident Advisor");
            $filter = 'accepted';
        }
        if($_GET['filter'] == "rejected"){
            $tableData = $residentManager->displayResidentByPosition("Block Rep");
            $filter = 'rejected';
        }
        if($_GET['filter'] == "pending"){
            $tableData = $residentManager->displayResidentByPosition("Resident");
            $filter = 'pending';
        }
    }
}

// for search query
if (isset($_GET['search-q'])) {
    $search = $_GET['search-q'];
    $tableData = $residentManager->displayResidents($search);
} else {
    $tableData = $residentManager->displayResidents();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="../resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <?php include '_header.php'; ?>

   

    <div class="container">
        <aside class="sidebar">
            <ul>
                <a href="./dashboard.php">
                    <li><i class="material-icons">home</i>Home</li>
                </a>
                <a href="./applicationProcessing.php">
                    <li><i class="material-icons">assignment</i>Application Processing</li>
                </a>
                <a href="./roomAssignment.php">
                    <li><i class="material-icons">hotel</i>Room Assignment</li>
                </a>
                <a href="#" class="currentPage">
                    <li><i class="material-icons">people_outline</i>Residents</li>
                </a>
                <a href="./noticeBoard.php">
                    <li><i class="material-icons">web</i>Notice Board</li>
                </a>
                <a href="./reportGeneration.php">
                    <li><i class="material-icons">assessment</i>Report Generation</li>
                </a>
                <hr>
                <a href="./logout.php">
                    <li><i class="material-icons">exit_to_app</i>Logout</li>
                </a>
            </ul>
        </aside>

        <!-- ENTER CODE HERE -->
        <main class="resident_page">
            <header>
                <h1 class="title">Resident Processing</h1>
            </header>

            <section class="search-resident">
                <form action="residentProcessing.php" method="get">
                    <div class="row">
                        <div class="heading">
                            <h3>Search Resident</h3>
                        </div>
                        <div class="search-field">
                            <input type="text" name="search-q" placeholder="ID or Resident Name"
                                value="<?= isset($_GET['search-q']) ? $_GET['search-q'] : '' ?>">
                        </div>
                        <div class="button">
                            <button type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </section>
          


            <section>
                <h2>Residents</h2>

                <div class="controls">
                    
                    <h3>Filter By:</h3>
                    <a href="./residentProcessing.php?filter=all" class="<?php if($filter == 'all'){echo 'active';} ?>  filter-all">All</a>
                    <a href="./residentProcessing.php?filter=Resident Advisor" class="<?php if($filter == 'Resident Advisor'){echo 'active';} ?> filter-resident Advisor">resident Advisor</a>
                    <a href="./residentProcessing.php?filter=Block Representative" class="<?php if($filter == 'Block Representative'){echo 'active';} ?> filter-Block Representative">Block Representative</a>
                    <a href="./residentProcessing.php?filter=Resident" class="<?php if($filter == 'Resident'){echo 'active';} ?> filter-Resident">Resident</a>
                </div>



                <table>
                    <colgroup>
                        <col style="width: 10%">
                        <col style="width: 25%">
                        <col style="width: 25%">
                        <col style="width: 25%">
                        <col style="width: 10%">
                        <col style="width: 25%">
                        <col style="width: 15%">
                        <col style="width: 10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Resident ID</th>
                            <th>Position</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Middle Initial</th>
                            <th>Home Address</th>
                            <th>Telephone Number</th>
                            <th>Room Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= (!empty($tableData)) ? $tableData : "<tr><td colspan='8' class='no-record'>No record found</td></tr>"; ?>
                    </tbody>
                </table>
            </section>

        </main>
    </div>

    <?php include '_footer.php' ?>
</body>

</html>
<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["voter_id"])) {
    redirectToLogin();
} else {
    $user_id = $_SESSION["voter_id"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>E voting system</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    	<![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        .results-container {
            margin-top: 20px;
        }

        .result-card {
            border: 1px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .result-card h4 {
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .candidate-list {
            list-style: none;
            padding: 0;
        }

        .candidate-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .candidate-item:last-child {
            border-bottom: none;
        }

        .candidate-name {
            font-size: 1.2rem;
        }

        .votes {
            font-weight: bold;
        }

        .candidate-item:hover {
            background-color: #eaf4ff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>

</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar menu-light ">
        <div class="navbar-wrapper  ">
            <div class="navbar-content scroll-div ">
                <ul class="nav pcoded-inner-navbar ">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Navigation</label>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Profile</span></a>
                    </li>

                    <li class="nav-item">
                        <a href="voting-page.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Voting page</span></a>
                    </li>

                    <li class="nav-item">
                        <a href="results.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext ">Election Results</span></a>
                    </li>

                    <li class="nav-item">
                        <a href="logout.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Logout</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">


        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            <a href="#!" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <p>
                    <h3 class="text-white">E.V.S</h3>
                </p>
            </a>
            <a href="#!" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
    </header>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="col-lg-7 col-md-12">
            </div>
            <div class="page-header">
                <div class="header">
                    <h1 class="text-white text-center">Election Results</h1>
                    <p class="text-white text-center">Here are the results for each position.</p>
                </div>
            </div>

            <?php
            $select_positions = mysqli_query($connect, "SELECT * FROM `position`");
            while ($position = mysqli_fetch_assoc($select_positions)) {
            ?>

                <div class="results-container">
                    <div class="result-card">
                        <h4><?php echo $position["position_name"] ?></h4>
                        <ul class="candidate-list">


                            <?php
                            $select_candidates = mysqli_query($connect, "SELECT * FROM `candidate` WHERE position_id = $position[position_id]");
                            while ($candidate = mysqli_fetch_assoc($select_candidates)) {
                            ?>
                                <?php
                                $select_votes = mysqli_query($connect, "SELECT candidate.candidate_name AS candidate_name,COUNT(election_result_id) AS noOfVotes FROM `candidate` LEFT JOIN `election_result` ON `election_result`.candidate_id = `candidate`.candidate_id WHERE `candidate`.candidate_id = $candidate[candidate_id]");
                                while ($election_result = mysqli_fetch_assoc($select_votes)) { ?>
                                    <li class="candidate-item">
                                        <span class="candidate-name">
                                            <?php echo $election_result["candidate_name"]; ?>
                                        </span>
                                        <span class="votes">
                                            <?php echo $election_result["noOfVotes"]; ?>
                                        </span>
                                    </li>
                                <?php } ?>

                            <?php } ?>

                        </ul>
                    </div>
                <?php } ?>





                </div>





                <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <!-- Apex Chart -->
    <script src="assets/js/plugins/apexcharts.min.js"></script>
    <!-- custom-chart js -->
    <script src="assets/js/pages/dashboard-main.js"></script>
</body>

</html>
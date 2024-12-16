<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["admin_id"])) {
    redirectToLogin();
} else {
    $admin_id = $_SESSION["admin_id"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>E Voting System - Admin Dashboard</title>
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
        .navbar {
            background-color: #007bff;
        }

        .navbar-brand h3 {
            color: white;
            font-weight: bold;
        }

        .header {
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
        }

        .container-fluid {
            margin-top: 20px;
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-body {
            text-align: center;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .card-panel {
            padding: 20px;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
                        <a href="manage-positions.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Positions</span></a>
                    </li>

                    <li class="nav-item">
                        <a href="manage-candidates.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Candidates</span></a>
                    </li>

                    <li class="nav-item">
                        <a href="manage-voters.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Voters</span></a>
                    </li>

                    <li class="nav-item">
                        <a href="election-results.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Election Results</span></a>
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
                <div class="header">
                    <h1 class="text-white">Welcome Admin! You're in Charge</h1>
                    <p>Manage everything related to elections</p>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Upcoming Elections -->
                <div class="col-md-6 mb-4">
                    <div class="card card-panel">
                        <h5 class="card-title">Available Positions</h5>
                        <div class="card-body">
                            <p class="card-text">Manage available positons details.</p>
                            <a href="manage-positions.php" class="btn btn-custom">Manage Positions</a>
                        </div>
                    </div>
                </div>

                <!-- Manage Candidates -->
                <div class="col-md-6 mb-4">
                    <div class="card card-panel">
                        <h5 class="card-title">Manage Candidates</h5>
                        <div class="card-body">
                            <p class="card-text">Add, edit, or remove candidates from the list.</p>
                            <a href="manage-candidates.php" class="btn btn-custom">Manage Candidates</a>
                        </div>
                    </div>
                </div>

                <!-- Manage Voters -->
                <div class="col-md-6 mb-4">
                    <div class="card card-panel">
                        <h5 class="card-title">Manage Voters</h5>
                        <div class="card-body">
                            <p class="card-text">View and manage registered voters.</p>
                            <a href="manage-voters.php" class="btn btn-custom">Manage Voters</a>
                        </div>
                    </div>
                </div>

                <!-- Election Results -->
                <div class="col-md-6 mb-4">
                    <div class="card card-panel">
                        <h5 class="card-title">Election Results</h5>
                        <div class="card-body">
                            <p class="card-text">View and analyze the results of past elections.</p>
                            <a href="election-results.php" class="btn btn-custom">View Results</a>
                        </div>
                    </div>
                </div>
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
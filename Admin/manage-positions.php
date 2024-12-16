<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["admin_id"])) {
    redirectToLogin();
} else {
    $admin_id = $_SESSION["admin_id"];

    // If a position is added
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $position_name = $_POST["position_name"];

        $insert_into_DB = mysqli_query($connect, "INSERT INTO `position` (position_name) VALUES('$position_name')");

        if ($insert_into_DB) {
            echo "
                <script>
                    alert('success!');
                    window.location.href='manage-positions.php';
                </script>
            ";
            die();
        }
    }


    
    // If a position is deleted 
    if (isset($_GET["action"]) && $_GET["action"] == 'delete') {
        $position_id = $_GET["position_id"];

        $deleting = mysqli_query($connect, "DELETE FROM `position` WHERE position_id=$position_id");

        if ($deleting) {
            echo "
                <script>
                    alert(`deleted!`);
                    window.location.href='manage-positions.php';
                </script>
            ";
            die();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Elections - E Voting System</title>
    <!-- Meta and Styles -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .page-header {
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .header h1 {
            font-size: 2rem;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .table thead th {
            background-color: #007bff;
            color: white;
        }

        .modal-content {
            border-radius: 0.5rem;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer {
            border-top: 1px solid #ddd;
        }

        .positions-list {
            list-style-type: none;
            padding: 0;
        }

        .positions-list li {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .positions-list li button {
            border: none;
            background-color: transparent;
            color: #dc3545;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar menu-light ">
        <div class="navbar-wrapper">
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Navigation</label>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="manage-positions.php" class="nav-link active"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Positions</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="manage-candidates.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Candidates</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="manage-voters.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Voters</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="election-results.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Election Results</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Logout</span></a>
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
                <h3 class="text-white">E.V.S</h3>
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
                <h1 class="text-white">Manage Positions</h1>
                <p>Organize and manage all positions/offices here.</p>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-custom" data-toggle="modal" data-target="#addPositionModal">Create Position</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Position</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="positionsTableBody">
                                        <?php
                                        $select_positions = mysqli_query($connect, "SELECT * FROM `position`");
                                        
                                        $row_number = 1;
                                        while ($row = mysqli_fetch_assoc($select_positions)) {
                                            echo "
                                                <tr>
                                                    <td>$row_number</td>
                                                    <td>$row[position_name]</td>
                                                    <td>
                                                        <a href='./manage-positions.php?action=delete&position_id=$row[position_id]' class='btn btn-danger btn-sm'>Delete</a>
                                                    </td>      
                                                </tr>
                                                ";
                                                $row_number++;
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- Add Position Modal -->
    <div class="modal fade" id="addPositionModal" tabindex="-1" role="dialog" aria-labelledby="addPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPositionModalLabel">Create New Position</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./manage-positions.php" method="post">
                        <div class="form-group">
                            <label for="positionName">Position Name</label>
                            <input type="text" class="form-control" name="position_name" id="positionName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Position</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
</body>

</html>
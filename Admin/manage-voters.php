<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["admin_id"])) {
    redirectToLogin();
} else {
    $admin_id = $_SESSION["admin_id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $voter_name = $_POST["voter_name"];
        $voter_matric_no = $_POST["voter_matric_no"];

        // Checking if the matric no already exist
        $select_matricno = mysqli_query($connect, "SELECT * FROM `voter` WHERE matricno = '$voter_matric_no'");

        if (mysqli_num_rows($select_matricno) > 0) {
            echo "
                <script>
                    alert(`Matric No. already exist!`);
                    window.location.href='manage-voters.php';
                </script>
            ";
            die();
        } else {
            $inserting = mysqli_query($connect, "INSERT INTO `voter` (fullname,matricno) VALUES('$voter_name','$voter_matric_no')");

            if ($inserting) {
                echo "
                    <script>
                        alert(`success!`);
                        window.location.href='manage-voters.php';
                    </script>
                ";
                die();
            }
        }
    }

    // If a voter is deleted 
    if (isset($_GET["action"]) && $_GET["action"] == 'delete') {
        $voter_id = $_GET["voter_id"];

        $deleting = mysqli_query($connect, "DELETE FROM `voter` WHERE voter_id=$voter_id");

        if ($deleting) {
            echo "
                <script>
                    alert(`deleted!`);
                    window.location.href='manage-voters.php';
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
    <title>Manage Voters - E Voting System</title>
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

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
                        <a href="manage-positions.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Positions</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="manage-candidates.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Candidates</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="manage-voters.php" class="nav-link active"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Voters</span></a>
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
                <h1 class="text-white">Manage Voters</h1>
                <p>Manage all registered voters here.</p>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header actions">
                            <button class="btn btn-custom" data-toggle="modal" data-target="#addVoterModal">Add Voter</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Matric No</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $select_voters = mysqli_query($connect, "SELECT * FROM `voter`");
                                        if (!mysqli_num_rows($select_voters) > 0) {
                                            echo "
                                                
                                                ";
                                        } else {
                                            $number = 1;
                                            while ($voter = mysqli_fetch_assoc($select_voters)) {
                                                echo "
                                                    <tr>
                                                        <td>{$number}</td>
                                                        <td>{$voter['fullname']}</td>
                                                        <td>{$voter['matricno']}</td>
                                                        <td>
                                                            <a type='submit' href='manage-voters.php?action=delete&voter_id=$voter[voter_id]' class='btn btn-danger btn-sm text-white'>Delete</a>
                                                        </td>
                                                    </tr>
                                                ";
                                                $number++;
                                            }
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

    <!-- Add Voter Modal -->
    <div class="modal fade" id="addVoterModal" tabindex="-1" role="dialog" aria-labelledby="addVoterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVoterModalLabel">Add New Voter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="manage-voters.php" method="post">
                        <div class="form-group">
                            <label for="voterName">Name</label>
                            <input type="text" class="form-control" id="voterName" name="voter_name" required>
                        </div>
                        <div class="form-group">
                            <label for="voterMatricNo">Matric No</label>
                            <input type="text" class="form-control" id="voterMatricNo" name="voter_matric_no" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Voter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Voter Modal -->

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>


</body>

</html>
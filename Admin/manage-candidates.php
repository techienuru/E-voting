<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["admin_id"])) {
    redirectToLogin();
} else {
    $admin_id = $_SESSION["admin_id"];

    // If a candidate is added
    if (isset($_POST["add_candidate"])) {
        $candidate_name = $_POST["candidate_name"];
        $position_id = $_POST["position_id"];

        $insert_into_DB = mysqli_query($connect, "INSERT INTO `candidate` (candidate_name,position_id) VALUES('$candidate_name',$position_id)");

        if ($insert_into_DB) {
            echo "
                <script>
                    alert('success!');
                    window.location.href='manage-candidates.php';
                </script>
            ";
            die();
        }
    }


    // If a candidate is deleted
    if (isset($_POST["candidate_id"])) {
        $candidate_id = $_POST["candidate_id"];

        $delete_from_DB = mysqli_query($connect, "DELETE FROM `candidate` WHERE candidate_id = $candidate_id");

        if ($delete_from_DB) {
            echo "
                <script>
                    alert('deleted!');
                    window.location.href='manage-candidates.php';
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
    <title>Manage Candidates - E Voting System</title>
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
            background-color: #007bff;
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
                        <a href="manage-candidates.php" class="nav-link active"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext text-white">Manage Candidates</span></a>
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
                <h1 class="text-white">Manage Candidates</h1>
                <p>Manage all candidates for the elections here.</p>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header actions">
                            <button class="btn btn-custom" data-toggle="modal" data-target="#addCandidateModal">Add Candidate</button>
                            <div>
                                <form action="./initiate-election.php" method="post" class="d-inline">
                                    <button type="submit" name="start_election" class="btn btn-success">Start Election</button>
                                </form>
                                <form action="./initiate-election.php" method="post" class="d-inline">
                                    <button type="submit" name="stop_election" class="btn btn-danger">Stop Election</button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $select_candidate = mysqli_query($connect, "SELECT * FROM `candidate` INNER JOIN `position` ON `candidate`.position_id = `position`.position_id");
                                        $row_number = 1;

                                        while ($row = mysqli_fetch_assoc($select_candidate)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row_number ?></td>
                                                <td><?php echo $row["candidate_name"] ?></td>
                                                <td><?php echo $row["position_name"] ?></td>
                                                <td>
                                                    <form action='./manage-candidates.php' method='post' class='d-inline'>
                                                        <input type='hidden' name='candidate_id' value='<?php echo $row["candidate_id"] ?>'>
                                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php $row_number++;
                                        } ?>
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

    <!-- Add Candidate Modal -->
    <div class="modal fade" id="addCandidateModal" tabindex="-1" role="dialog" aria-labelledby="addCandidateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCandidateModalLabel">Add New Candidate</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./manage-candidates.php" method="post">
                        <div class="form-group">
                            <label for="candidateName">Name</label>
                            <input type="text" class="form-control" id="candidateName" name="candidate_name" required>
                        </div>
                        <div class="form-group">
                            <label for="candidatePosition">Position</label>
                            <select class="form-control" id="candidatePosition" name="position_id" required>
                                <?php
                                $select_positions = mysqli_query($connect, "SELECT * FROM `position`");

                                while ($row = mysqli_fetch_assoc($select_positions)) {
                                ?>
                                    <option value="<?php echo $row["position_id"] ?>"><?php echo $row["position_name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button type="submit" name="add_candidate" class="btn btn-primary">Add Candidate</button>
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
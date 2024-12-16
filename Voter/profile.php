<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["voter_id"])) {
    redirectToLogin();
} else {
    $user_id = $_SESSION["voter_id"];

    $select_user_details = mysqli_query($connect, "SELECT * FROM `voter` WHERE voter_id=$user_id");
    $fetch_user_details = mysqli_fetch_assoc($select_user_details);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        $insert_into_DB = mysqli_query($connect, "UPDATE `voter` SET password = '$new_password' WHERE voter_id = $user_id");

        if ($insert_into_DB) {
            echo "
                <script>
                    alert('success!');
                    window.location.href='profile.php';
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
                        <a href="results.php" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Election Results</span></a>
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


            <div class="pcoded-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="header">
                        <h1 class="text-white">Student's Profile</h1>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->
                <!-- [ Main Content ] start -->

                <div class="card">
                    <div class="card-body">
                        <form>

                            <div class="form-group">
                                <label for="studentName">Full Name</label>
                                <input type="text" class="form-control" id="studentName" value="<?php echo $fetch_user_details["fullname"]; ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="matricNumber">Matric Number</label>
                                <input type="text" class="form-control" id="matricNumber" value="<?php echo $fetch_user_details["matricno"]; ?>" readonly>
                            </div>

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updatePasswordModal">Update Password</button>

                        </form>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->

        </div>
        <!-- [ Main Content ] end -->

        <!-- Password Update Modal -->
        <div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                            <div class="form-group">
                                <label for="newPassword">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="newPassword" required>
                                <small class="text-danger js-password-error"></small>
                            </div>

                            <div class="form-group">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" id="confirmPassword" required>
                                <small class="text-danger js-password-error"></small>
                            </div>

                            <button type="submit" class="btn btn-primary js-save-changes">Save changes</button>

                        </form>
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



    <!-- custom-chart js -->
    <script src="assets/js/pages/dashboard-main.js"></script>
    <script>
        const newPasswordElement = document.querySelector('#newPassword');
        const confirmPasswordElement = document.querySelector('#confirmPassword');
        const saveChangesElement = document.querySelector('.js-save-changes');

        const errorTagElement = document.querySelectorAll(".js-password-error");


        saveChangesElement.addEventListener("click", (e) => {
            if (newPasswordElement.value != confirmPasswordElement.value) {
                e.preventDefault();
                errorTagElement.forEach((errorTagElement) => {
                    errorTagElement.innerText = "Password Mismatch";
                });
            }
        });
    </script>
</body>

</html>
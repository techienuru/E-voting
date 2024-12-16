<?php
include_once "./includes/connect.php";
include_once "./includes/functions.php";

// If Matric Number is passed from 'register-matricno.php' page
if (isset($_GET["matricno"])) {
    $matricno = $_GET["matricno"];

    $select_from_voter = mysqli_query($connect, "SELECT * FROM `voter` WHERE matricno=$matricno");

    $check_if_acc_exist = mysqli_query($connect, "SELECT * FROM `voter` WHERE matricno=$matricno AND password IS NULL");

    if (!mysqli_num_rows($select_from_voter) > 0) {
        echo "
            <script>
                alert('Not a registered voter');
                window.location.href='register-matricno.php';
            </script>
        ";
        die();
    }elseif (!mysqli_num_rows($check_if_acc_exist) > 0) {
        echo "
            <script>
                alert('User exist!');
                window.location.href='register-matricno.php';
            </script>
        ";
        die();
    } else {
        $fetch_voter_details = mysqli_fetch_assoc($select_from_voter);
        $voter_id = $fetch_voter_details["voter_id"];
        $fullname = $fetch_voter_details["fullname"];

        // If a password is filled and submitted
        if (isset($_POST["submit"])) {
            $password = $_POST["password"];

            $update_voter_table = mysqli_query($connect, "UPDATE `voter` SET password = '$password' WHERE voter_id=$voter_id");

            if ($update_voter_table) {
                echo "
                    <script>
                        alert('success!');
                        window.location.href='login.php';
                    </script>
                ";
                die();
            }
        }
    }
} else {
    header("location:login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Ablepro v8.0 bootstrap admin template by Phoenixcoded</title>
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
    <link rel="icon" href="admin/assets/images/favicon.ico" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="admin/assets/css/style.css">




</head>

<!-- [ auth-signup ] start -->
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="post">
                            <h4 class="mb-3 f-w-400">Sign up</h4>
                            <div class="form-group mb-3">
                                <label class="floating-label" for="Fullname">Full Name</label>
                                <input type="text" class="form-control" name="fullname" id="Fullname" placeholder="" value="<?php echo $fullname; ?>" readonly>
                            </div>

                            <div class="form-group mb-4">
                                <label class="floating-label" for="Password">Password</label>
                                <input type="password" name="password" class="form-control" id="Password" placeholder="" required>
                            </div>
                            <button class="btn btn-primary btn-block mb-4" name="submit" type="submit">Sign up</button>

                            <p class="mb-2">Already have an account? <a href="./login.php" class="f-w-400">Signin</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signup ] end -->

<!-- Required Js -->
<script src="admin/assets/js/vendor-all.min.js"></script>
<script src="admin/assets/js/plugins/bootstrap.min.js"></script>
<script src="admin/assets/js/ripple.js"></script>
<script src="admin/assets/js/pcoded.min.js"></script>



</body>

</html>
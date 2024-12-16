<?php
session_start();
include_once "./includes/connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$email_matric = $_POST["email_matric"];
	$password = $_POST["password"];

	// Selecting from admin
	$selecting_from_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE email = '$email_matric' AND password = '$password'");

	// Selecting from voter
	$selecting_from_voter = mysqli_query($connect, "SELECT * FROM `voter` WHERE matricno = '$email_matric' AND password = '$password'");

	if (!mysqli_num_rows($selecting_from_admin) > 0 && !mysqli_num_rows($selecting_from_voter) > 0) {
		echo "
			<div class='alert alert-danger'>
				Invalid Credential
				<button type='button' class='close' data-dismiss='alert'><span>&times;</span></button>
			</div>
		";
	} else {

		if (mysqli_num_rows($selecting_from_admin) > 0) {
			$fetching_admin_details = mysqli_fetch_assoc($selecting_from_admin);
			$_SESSION["admin_id"] = $fetching_admin_details["admin_id"];
			header("location:Admin/dashboard.php");
			die();
		}

		if (mysqli_num_rows($selecting_from_voter) > 0) {
			$fetching_voter_details = mysqli_fetch_assoc($selecting_from_voter);
			$_SESSION["voter_id"] = $fetching_voter_details["voter_id"];
			header("location:Voter/dashboard.php");
			die();
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<title>EVS - E-Voting System</title>
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
	<link rel="icon" href="voter/assets/images/favicon.ico" type="image/x-icon">

	<!-- vendor css -->
	<link rel="stylesheet" href="voter/assets/css/style.css">




</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
					<div class="card-body">
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
							<h4 class="mb-3 f-w-400">Signin</h4>
							<div class="form-group mb-3">
								<label class="floating-label" for="Email">Email address or Matric Number</label>
								<input type="text" class="form-control" name="email_matric" id="Email" placeholder="" required>
							</div>
							<div class="form-group mb-4">
								<label class="floating-label" for="Password">Password</label>
								<input type="password" class="form-control" name="password" id="Password" placeholder="" required>
							</div>
							<button class="btn btn-block btn-primary mb-4">Signin</button>
							<p class="mb-0 text-muted">Don’t have an account? <a href="./register-matricno.php" class="f-w-400">Signup</a></p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="./voter/assets/js/vendor-all.min.js"></script>
<script src="voter/assets/js/plugins/bootstrap.min.js"></script>
<script src="voter/assets/js/ripple.js"></script>
<script src="voter/assets/js/pcoded.min.js"></script>



</body>

</html>
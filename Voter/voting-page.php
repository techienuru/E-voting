<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["voter_id"])) {
    redirectToLogin();
} else {
    $user_id = $_SESSION["voter_id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Looping through each position and recording the vote
        foreach ($_POST as $position_id => $candidate_id) {

            // Checking if the particular arrat value has "position" word
            if (strpos($position_id, 'position') === 0) {
                // Extracting the position ID from the key
                $position_id = str_replace('position', '', $position_id);


                // Insert the vote into the database
                $insert_vote = mysqli_query($connect, "INSERT INTO `election_result` (`voter_id`, `candidate_id`, `position_id`) VALUES ('$user_id', '$candidate_id', '$position_id')");

                if (!$insert_vote) {
                    // Handle error if the vote couldn't be recorded
                    echo "
                        <script>
                            alert('An error occurred while submitting your vote. Please try again.!');
                            window.location.href='voting-page.php';
                        </script>
                    ";
                    exit;
                }
            }
        }

        // Displaying success Message after Inserting all values
        if ($insert_vote) {
            echo "
                <script>
                    alert('Thank you for voting! Your vote has been recorded.');
                    window.location.href='voting-page.php';
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
    <title>E Voting System</title>
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

        .card {
            transition: transform 0.2s ease-in-out;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .card-body {
            padding: 20px;
        }

        .candidate-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .candidate-card:hover {
            background-color: #f0f8ff;
        }

        .candidate-name {
            font-size: 1rem;
            font-weight: bold;
        }

        .candidate-radio {
            margin-right: 20px;
        }

        .submit-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0056b3;
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
                <div class="header">
                    <h1 class="text-white">Click and Submit to vote!</h1>
                    <p>Your voice, your vote!</p>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="container-fluid mt-5">
                <form action="./voting-page.php" method="post">
                    <?php
                    // Checking if election status is On(1)
                    $select_election_status = mysqli_query($connect, "SELECT * FROM `initiate_election`");
                    $fetch_election_status = mysqli_fetch_assoc($select_election_status);
                    $election_status = $fetch_election_status["election_on"];

                    // Checking if user has voted before
                    $select_from_election_result = mysqli_query($connect, "SELECT * FROM `election_result` WHERE voter_id = $user_id");

                    if (!$election_status) {
                        echo "<div class='alert alert-danger'>No elections available yet, check back later</div>";
                    } elseif (mysqli_num_rows($select_from_election_result) > 0) {
                        echo "
                            <div class='alert alert-success'>Thank you for voting! Your vote has already been recorded.</div>
                        ";
                    } else {
                        $positions_array = [];
                        $select_positions = mysqli_query($connect, "SELECT * FROM `position`");

                        while ($row = mysqli_fetch_assoc($select_positions)) {
                            $position_id = $row["position_id"];
                            $position_name = $row["position_name"];
                            array_push($positions_array, ["id" => $position_id, "name" => $position_name]);
                        }

                        foreach ($positions_array as $position) {
                            echo "<div class='card'>
                                    <div class='card-body'>";
                            $select_candidates = mysqli_query($connect, "SELECT * FROM `candidate` WHERE `position_id` = {$position['id']}");

                            while ($row = mysqli_fetch_assoc($select_candidates)) {
                                echo "<div class='candidate-card'>
                                        <span class='candidate-details'>$row[candidate_name] - $position[name]</span>
                                        <input type='radio' name='position{$position['id']}' value='$row[candidate_id]' class='candidate-radio' required>
                                    </div>";
                            }
                            echo "</div></div>";
                        }
                        echo "
                                <button type='submit' class='submit-btn'>Submit Vote</button>
                            </form>
                        ";
                    }
                    ?>
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
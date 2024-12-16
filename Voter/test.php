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
    <title>E Voting System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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

        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .candidate-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .candidate-card:hover {
            background-color: #f0f8ff;
        }

        .candidate-details {
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

<body>
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="header">
                    <h1 class="text-white">Click and Submit to vote!</h1>
                    <p>Your voice, your vote!</p>
                </div>
            </div>
            <div class="container-fluid mt-5">
                
            </div>
        </div>
    </div>
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
</body>

</html>

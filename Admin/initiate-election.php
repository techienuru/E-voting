<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/functions.php";

if (!isset($_SESSION["admin_id"])) {
    redirectToLogin();
} else {
    $admin_id = $_SESSION["admin_id"];

    if (isset($_POST["start_election"])) {

        $start_election = mysqli_query($connect, "UPDATE `initiate_election` SET election_on = 1");

        if ($start_election) {
            echo "
                <script>
                    alert('Election is on!');
                    window.location.href='manage-candidates.php';
                </script>
            ";
            die();
        }
    }

    if (isset($_POST["stop_election"])) {

        $stop_election = mysqli_query($connect, "UPDATE `initiate_election` SET election_on = 0");

        if ($stop_election) {
            echo "
                <script>
                    alert('Election is stopped!');
                    window.location.href='manage-candidates.php';
                </script>
            ";
            die();
        }
    }
}

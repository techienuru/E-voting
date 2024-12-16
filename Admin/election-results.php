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
    <title>Election Results - E Voting System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="View the results of the elections" />
    <meta name="keywords" content="">
    <meta name="author" content="Your Name" />
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

        .results-card {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
        }

        .results-card h3 {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 10px;
        }

        .candidate {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .candidate:last-child {
            border-bottom: none;
        }

        .candidate .name {
            font-weight: bold;
        }

        .candidate .votes {
            color: #007bff;
            font-weight: bold;
        }

        .export-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
    </style>
</head>

<body>
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
                        <a href="manage-voters.php" class="nav-link"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Manage Voters</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="election-results.php" class="nav-link active"><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Election Results</span></a>
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
                <h1 class="text-white">Election Results</h1>
                <p>View the results of the elections</p>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row mt-5">
                <div class="col-lg-12">
                    <!-- Export buttons -->
                    <div class="export-buttons">
                        <button onclick="exportToPDF()">Export to PDF</button>
                        <button onclick="exportToExcel()">Export to Excel</button>
                    </div>
                    <?php
                    $select_positions = mysqli_query($connect, "SELECT * FROM `position`");
                    while ($position = mysqli_fetch_assoc($select_positions)) {
                    ?>
                        <div class="results-card">
                            <h3><?php echo $position["position_name"] ?></h3>
                            <?php
                            $select_candidates = mysqli_query($connect, "SELECT * FROM `candidate` WHERE position_id = $position[position_id]");
                            while ($candidate = mysqli_fetch_assoc($select_candidates)) {
                            ?>
                                <?php
                                $select_votes = mysqli_query($connect, "SELECT candidate.candidate_name AS candidate_name,COUNT(election_result_id) AS noOfVotes FROM `candidate` LEFT JOIN `election_result` ON `election_result`.candidate_id = `candidate`.candidate_id WHERE `candidate`.candidate_id = $candidate[candidate_id]");
                                while ($election_result = mysqli_fetch_assoc($select_votes)) { ?>
                                    <div class="candidate">
                                        <span class="name"><?php echo $election_result["candidate_name"]; ?></span>
                                        <span class="votes"><?php echo $election_result["noOfVotes"]; ?></span>
                                    </div>
                                <?php } ?>

                            <?php } ?>

                        </div>

                    <?php }  ?>

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

    <!-- jsPDF and SheetJS libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script>
        // Export to PDF function
        function exportToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Get all results cards
            const cards = document.querySelectorAll('.results-card');
            let y = 10;

            cards.forEach(card => {
                const title = card.querySelector('h3').innerText;
                doc.setFontSize(14);
                doc.text(title, 10, y);
                y += 10;

                const candidates = card.querySelectorAll('.candidate');
                candidates.forEach(candidate => {
                    const name = candidate.querySelector('.name').innerText;
                    const votes = candidate.querySelector('.votes').innerText;
                    doc.setFontSize(12);
                    doc.text(`${name}: ${votes}`, 10, y);
                    y += 10;
                });

                y += 10; // Add space between cards
            });

            doc.save('election-results.pdf');
        }

        // Export to Excel function
        function exportToExcel() {
            const ws = XLSX.utils.aoa_to_sheet([]);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Results");

            // Get all results cards
            const cards = document.querySelectorAll('.results-card');

            cards.forEach((card, index) => {
                const title = card.querySelector('h3').innerText;
                const candidates = card.querySelectorAll('.candidate');

                // Append title and candidates to the worksheet
                XLSX.utils.sheet_add_aoa(ws, [
                    [title]
                ], {
                    origin: -1
                });
                candidates.forEach(candidate => {
                    const name = candidate.querySelector('.name').innerText;
                    const votes = candidate.querySelector('.votes').innerText;
                    XLSX.utils.sheet_add_aoa(ws, [
                        [name, votes]
                    ], {
                        origin: -1
                    });
                });

                // Add empty row between cards
                if (index < cards.length - 1) {
                    XLSX.utils.sheet_add_aoa(ws, [
                        []
                    ], {
                        origin: -1
                    });
                }
            });

            XLSX.writeFile(wb, 'election-results.xlsx');
        }
    </script>
</body>

</html>
<?php
require_once "../resources/config.php";

if (isset($_GET["search"])) {
    $pdo = openConnection();
    $query = "SELECT company_name FROM open_review.employer WHERE company_name LIKE '" . $_GET["search"] . "%'";
    $result = $pdo->query($query);
    $pdo = null;

    $c = 0;
    while ($row = $result->fetch() and $c < 5) {
        echo "<div class='suggestion-item'>" . $row["company_name"] . "</div>";
        $c++;
    }
}

if (isset($_GET["company_reviews"]) and isset($_GET["limit"])) {
    $pdo = openConnection();
    $query = "SELECT * FROM employerreview_s WHERE employerId = (SELECT employer_id FROM open_review.employer WHERE company_name = '" . $_GET["company_reviews"] . "') LIMIT ".$_GET["limit"].", ".($_GET["limit"]+20);
    $result = $pdo->query($query);
    $pdo = null;

    while ($row = $result->fetch()) {
        echo "<tr><td>".$row['advice']."</td><td>".$row['pros']."</td><td>".$row['cons']."</td></tr>";
    }
}
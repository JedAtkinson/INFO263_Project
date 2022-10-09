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

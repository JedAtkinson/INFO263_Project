<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employer Rankings</title>
</head>
<body>
<h1>Employer Ratings</h1>
<?php
require_once "../resources/config.php";

if (isset($_GET["search_term"])) {
    $pdo = openConnection();
    $query = "SELECT * FROM open_review.reviewedemployer_s WHERE company_name = '" . $_GET["search_term"]."'";
    $result = $pdo->query($query);
    $pdo = null;

    if ($result->rowCount() === 0) {
        echo "<p>No data on this employer</p>";
        echo "<button>Add review</button>";
    } else {
        $c = 0;
        $row = $result->fetch();

        echo "<h2><img alt='".$row["company_name"]." Logo' height='16' width='16' style='padding-right: 10px;' src='http://www.google.com/s2/favicons?domain=".$row["company_url"]."'>";
        echo $row['company_name']."</h2>";

        foreach ($row as $key => $value) {
            $name = ucfirst(implode(" ", explode("_", $key)));
            echo "<p><b>".$name.":</b> ".$value."</p>";
        }
    }
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>
</html>


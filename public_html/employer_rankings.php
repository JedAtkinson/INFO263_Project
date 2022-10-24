<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="View an overview of all reviews left on any employer on all catagroies and graphical representations">
    <meta name="keywords" content="open review, review employer, employers search, company reviews">
    <meta name="author" content="Jed Atkinson">

    <title>Employer Rankings</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Employer Ratings</h1>

<?php
require_once "../resources/config.php";

if (isset($_GET["employer"])) {
    $result = get_reviewed_employer($_GET["employer"]);

    if ($result->rowCount() === 0) {
        echo "<p>No data on this employer</p>";
        echo "<button onclick=\"location.href='review_employer.php?employer=".$_GET["employer"]."'\">Add review</button>";
    } else {
        $row = $result->fetch();

        echo '
<nav style="padding: 0px;">
    <a href="index.html">Home</a>
    <a href="review_employer.php?employer='.$_GET["employer"].'">Add Review</a>
    <a href="employer_reviews.php?employer='.$_GET["employer"].'">View Reviews</a>
</nav>
        ';

        echo "<h2><img alt='".$row["company_name"]." Logo' class='employer_logo' src='http://www.google.com/s2/favicons?domain=".$row["company_url"]."'>";
        echo $row['company_name']."</h2>";

        echo '<div class="left_div">';

        foreach ($row as $key => $value) {
            if ($value === null) $value = 0;
            $name = ucfirst(implode(" ", explode("_", $key)));
            echo "<p><b>".$name.":</b> ".$value."</p>";
        }

        $out_of_5_ratings = array("career_opportunities_rating" => "Career Opportunities Rating",
            "compensation_and_benefits_rating" => "Compensation And Benefits Rating",
            "culture_and_values_rating" => "Culture And Values Rating",
            "diversity_and_inclusion_rating" => "Diversity And Inclusion Review",
            "overall_rating" => "Overall Rating",
            "senior_leadership_rating" => "Senior Leadership Rating",
            "work_life_balance_rating" => "Work Life Balance Rating");

        $data = [];
        foreach (array_keys($out_of_5_ratings) as $item) {
            array_push($data, floatval($row[$item]));
        }
    }
}
?>

</div>

<div class="right_div">
    <canvas id="ratings_chart"></canvas>
</div>

<script>
    const labels = <?php echo json_encode(array_values($out_of_5_ratings)) ?>;

    const data = {
        labels: labels,
        datasets: [{
            label: 'Ratings',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($data) ?>
        }]
    };

    const config = {
        type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5
                }
            }
        }
    };

    const myChart = new Chart(
        document.getElementById('ratings_chart'),
        config
    );
</script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
        echo "<button onclick=\"location.href='review_employer.php\">Add review</button>";
    } else {
        $row = $result->fetch();

        echo '<a href="employer_reviews.php?search_term='.$row["company_name"].'"><button type="submit" style="float: right; margin-right: 50%;">See all Reviews</button></a>';

        echo "<h2><img alt='".$row["company_name"]." Logo' height='16' width='16' style='padding-right: 10px;' src='http://www.google.com/s2/favicons?domain=".$row["company_url"]."'>";
        echo $row['company_name']."</h2>";

        echo '<div style="width: 50%; display: inline-block; text-align: center;">';

        foreach ($row as $key => $value) {
            if ($value === null) $value = 0;
            $name = ucfirst(implode(" ", explode("_", $key)));
            echo "<p><b>".$name.":</b></p><p> ".$value."</p>";
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

<div style="width: 50%; display: inline-block; float: right;">
    <canvas id="myChart"></canvas>
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
        document.getElementById('myChart'),
        config
    );
</script>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employer Reviews</title>

    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<h1>Employer Ratings</h1>
<?php
if (isset($_GET["search_term"])) {
    echo "<h2 id='company_name'>".$_GET["search_term"]."</h2>";
}
?>

<div id="reviews_table">

</div>

<button onclick="load_more_button()">Load More</button>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

<script>
    let limit = 0

    load_reviews($("#company_name").text(), limit);
    limit += 5;

    function load_more_button() {
        (load_reviews($("#company_name").text(), limit));
        limit += 5;
    }
</script>
</body>
</html>


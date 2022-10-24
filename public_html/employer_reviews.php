<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="View through our catalog of reviews from thousands of stored employers">
    <meta name="keywords" content="open review, review employer, employers search, company reviews">
    <meta name="author" content="Jed Atkinson">

    <title>Employer Reviews</title>

    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<h1>Employer Reviews</h1>

<?php
require_once "../resources/config.php";
if (isset($_GET["employer"])) {
    $result = get_employer($_GET["employer"])->fetch();

    echo '
<nav style="padding: 0px;">
    <a href="index.php">Home</a>
    <a href="review_employer.php?employer='.$_GET["employer"].'">Add Review</a>
    <a href="employer_reviews.php?employer='.$_GET["employer"].'">View Reviews</a>
</nav>
        ';

    echo "<h2><img alt='".$result["company_name"]." Logo' class='employer_logo' src='http://www.google.com/s2/favicons?domain=".$result["company_url"]."'>".$result['company_name']."</h2>";
    echo "<input type='hidden' id='employer_id' value='".$_GET["employer"]."'>";
}
?>

<div id="reviews_table">

</div>

<button onclick="load_more_button()">Load More</button>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

<script>
    let limit = 0

    load_reviews($("#employer_id").val(), limit);
    limit += 5;

    function load_more_button() {
        (load_reviews($("#employer_id").val(), limit));
        limit += 5;
    }
</script>
</body>
</html>


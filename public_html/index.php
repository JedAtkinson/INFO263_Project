<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Open review portal for viewing and adding reviews on thousands of stored employers">
    <meta name="keywords" content="open review, review employer, employers search, company reviews">
    <meta name="author" content="Jed Atkinson">

    <title>Open Review Portal</title>

    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<h1>Open Review Portal</h1>

<nav>
  <a href="index.php">Home</a>
  <a href="review_employer.php">Review an Employer</a>
</nav>

<div class="employer_search">
    <h2><label for="employer_search_box">Search Employers</label></h2>
    <input type="text" id="employer_search_box" name="search_term" placeholder="Search" autocomplete="off">
    <div id="employer_search_suggestions"></div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

<script>
    $("#employer_search_box").keyup(function() {
        $("#employer_search_suggestions").html(update_employer_suggestions($("#employer_search_box").val()));
    });

    $("#employer_search_suggestions").on("click", '.suggestion-item', function() {
        window.location.href = "employer_rankings.php?employer="+this.id;
    });

    $("#employer_search_suggestions").on('focus', '.suggestion-item', function() {
        $("#employer_search_box").val($(this).text());
    });
</script>
</body>
</html>
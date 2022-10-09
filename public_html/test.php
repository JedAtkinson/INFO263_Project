<?php
require_once "../resources/config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Testing page</title>

    <style>
        #suggestions {
            position: fixed;
            z-index: 2;
        }

        .suggestion-item {
            background-color: #dddddd;
            margin: 2px;
            user-select: none;
        }

        .suggestion-item:hover {
            background-color: #888888;
        }
    </style>
</head>
<body>
<h1>A page for testing stuff</h1>

<form action="test.php" method="POST" style="padding: 10px;">
    <input type="text" name="search" id="companySearch" placeholder="Company name" autocomplete="off">
    <div id="suggestions"></div>
    <input type="submit">
</form>

<?php
if (isset($_POST["search"])) {
    $pdo = openConnection();
    $query = "SELECT * FROM open_review.employer WHERE company_name LIKE '".$_POST["search"]."%'";
    $result = $pdo->query($query);
    $pdo = null;

    echo "<table><tr><th>Company</th><th>HQ</th><th>URL</th></tr>";
    $c = 0;
    while ($row = $result->fetch() and $c < 10) {
        echo "<tr><td><img alt='".$row["company_name"]." Logo' height='16' width='16' style='padding-right: 10px;' src='http://www.google.com/s2/favicons?domain=".$row["company_url"]."'>".$row["company_name"]."</td>";
        echo "<td>".$row["company_hq"]."</td><td><a href='".$row["company_url"]."'>".$row["company_url"]."</a></td></tr>";
        $c++;
    }
    echo "</table>";

    if ($c === 0) {
        echo "No results found";
    }
}
?>

<script>
    document.getElementById("companySearch").addEventListener("input", function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("suggestions").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "nameSuggestion.php?search="+document.getElementById("companySearch").value, true);
        xhttp.send();
    });
</script>

</body>
</html>
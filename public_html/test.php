<?php
require_once "../resources/config.php";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Testing page</title>
</head>
<body>
<h1>A page for testing stuff</h1>

<?php
$pdo = openConnection();
$result = $pdo->query("SELECT * FROM employer WHERE employer_id < 20");

echo "<table><tr><th>Name</th><th>Company HQ</th><th>Company URL</th></tr>";
while ($row = $result->fetch()) {
    echo "<tr><td>".$row["company_name"]."</td><td>".$row["company_hq"]."</td><td>".$row["company_url"]."</td>";
}
echo "</table>";

closeConnection($pdo);
?>

</body>
</html>
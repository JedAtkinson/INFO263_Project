<?php
/**
 * Create connection to the database
 *
 * @return PDO object which is the connection to the database
 */
function openConnection()
{
    $host = 'localhost';
    $data = 'open_review';
    $user = 'root';
    $pass = 'mysql';
    $chrs = 'utf8mb4';
    $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
    $opts =[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($attr, $user, $pass, $opts);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    return $pdo;
}

/**
 * Close connection to given database
 *
 * @param $pdo PDO object
 */
function closeConnection($pdo)
{
    $pdo = null;
}

function searchEmployers($search_term, $num_results) {
    $pdo = openConnection();
    $query = "SELECT employer_id, company_name, company_url FROM open_review.employer WHERE company_name LIKE '" . $search_term . "%' LIMIT $num_results";
    $result = $pdo->query($query);
    $pdo = null;

    return $result;
}

function getEmployersReviews($employer, $range_min, $range_max) {
    $pdo = openConnection();
    $query = "SELECT * FROM employerreview_s WHERE employerId = (SELECT employer_id FROM open_review.employer WHERE company_name = '" . $employer . "') LIMIT ".$range_min.", ".$range_max;
    $result = $pdo->query($query);
    $pdo = null;

    return $result;
}

function display_as_table($result, $columns) {
    $table = "<table><tr>";
    foreach ($columns as $col) {
        $name = ucfirst(implode(" ", preg_split('/(?=[A-Z])/',$col)));
        $table .= "<th id=".$col.">".$name."</th>";
    }
    $table .= "</tr>";
    while ($row = $result->fetch()) {
        $table .= "<tr>";
        foreach ($columns as $col) {
            $table .= "<td>".$row[$col]."</td>";
        }
        $table .= "</tr>";
    }
    $table .= "</table>";

    return $table;
}

function get_reviewed_employer($employer) {
    $pdo = openConnection();
    $query = "SELECT * FROM reviewedemployer_s WHERE employer_id = ".$employer;
    $result = $pdo->query($query);
    $pdo = null;

    return $result;
}

function add_review($data) {
    try {
        $pdo = openConnection();
        $query = "INSERT INTO employerreview_s (" . implode(', ', array_keys($data)) . ") 
        VALUES " . implode(', ', array_values($data)) . ")";
        $pdo->exec($query);
        return true;
    } catch(PDOException $e) {
        return $e->getMessage();
    }

    $pdo = null;
}
?>
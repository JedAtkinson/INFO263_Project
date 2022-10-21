<?php
require_once "../resources/config.php";

if (isset($_GET["search"])) {
    $result = searchEmployers($_GET["search"], 5);

    while ($row = $result->fetch()) {
        echo "<div class='suggestion-item' id='".$row["employer_id"]."' tabindex='0'>
<img alt='".$row["company_name"]." Logo' height='16' width='16' style='padding-right: 10px;' src='http://www.google.com/s2/favicons?domain=".$row["company_url"]."'>" . $row["company_name"] . "</div>";
    }
}

if (isset($_GET["company_reviews"]) and isset($_GET["limit"])) {
    $result = getEmployersReviews($_GET["company_reviews"], $_GET["limit"], $_GET["limit"]+5);
    $columns = ['reviewDateTime', 'employmentStatus', 'isCurrentJob', 'jobEndingYear', 'jobTitle', 'lengthOfEmployment', 'advice', 'cons', 'pros', 'ratingBusinessOutlook', 'ratingCareerOpportunities', 'ratingCeo', 'ratingCompensationAndBenefits', 'ratingCultureAndValues', 'ratingDiversityAndInclusion', 'ratingOverall', 'ratingRecommendToFriend', 'ratingSeniorLeadership', 'ratingWorkLifeBalance', 'summary'];


    while ($row = $result->fetch()) {
        echo "<div style='border: 2px solid black'>";
        echo "<div style='width: 50%; display: inline-block; vertical-align: top;'>";
        foreach (array_slice($columns, 0, count($columns)/2) as $col) {
            if (strlen($row[$col]) > 0) {
                $name = ucfirst(implode(" ", preg_split('/(?=[A-Z])/', $col)));
                echo "<h3 id=" . $col . ">" . $name . "</h3>";
                echo "<p>" . $row[$col] . "</p>";
            }
        }
        echo '</div>';
        echo "<div style='width: 40%; margin-left: 50px; display: inline-block; vertical-align: top;'>";
        foreach (array_slice($columns, count($columns)/2) as $col) {
            if (strlen($row[$col]) > 0) {
                $name = ucfirst(implode(" ", preg_split('/(?=[A-Z])/', $col)));
                echo "<h3 id=" . $col . ">" . $name . "</h3>";
                echo "<p>" . $row[$col] . "</p>";
            }
        }
        echo "</div></div>";
    }

//    $columns = ['reviewDateTime', 'advice', 'cons', 'employmentStatus', 'isCurrentJob', 'jobEndingYear', 'jobTitle', 'lengthOfEmployment', 'pros', 'ratingBusinessOutlook', 'ratingCareerOpportunities', 'ratingCeo', 'ratingCompensationAndBenefits', 'ratingCultureAndValues', 'ratingDiversityAndInclusion', 'ratingOverall', 'ratingRecommendToFriend', 'ratingSeniorLeadership', 'ratingWorkLifeBalance', 'summary'];
//    echo display_as_table($result, $columns);
}
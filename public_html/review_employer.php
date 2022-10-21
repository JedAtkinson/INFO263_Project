<?php
require_once "../resources/config.php";
$values = ["advice","cons","employmentStatus","jobTitle","lengthOfEmployment","pros","ratingBusinessOutlook","ratingCareerOpportunities","ratingCeo","ratingCompensationAndBenefits","ratingCultureAndValues","ratingDiversityAndInclusion","ratingOverall","ratingRecommendToFriend","ratingSeniorLeadership","ratingWorkLifeBalance","summary"];

$all_set = true;
$data = [];
foreach ($values as $value) {
    if (isset($_GET[$value])) {
        $data[$value] = $_GET[$value];
    } else {
        $all_set = false;
    }
}

if (isset($_GET["isCurrentJob"]) and isset($_GET["jobEndingYear"])) {
    $data["isCurrentJob"] = 1;
    $data["jobEndingYear"] = $_GET["jobEndingYear"];
} else {
    $data["isCurrentJob"] = 0;
    $data["jobEndingYear"] = null;
}

if ($all_set) {
    $data["employerId"] = 1;
    $data["reviewDateTime"] = date('Y-m-d H:i:s');
    //add_review($data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Employer</title>

    <link rel="stylesheet" href="css/style.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>
<body>

<h1>Review Employer</h1>

<form method="get" action="review_employer.php">
    <div style="width: 700px; display: inline-block;">
    <p><label for="employer_search_box">Employer</label></p>
    <input type="text" id="employer_search_box" name="employer_search_box" required placeholder="Search" autocomplete="off"
           style="width: 500px" <?php echo (isset($_GET['employer'])) ? 'value="'.$_GET['employer'].'"' : ''; ?>>
    <div id="employer_search_suggestions"></div>

    <?php
    $text_ratings = array("advice" => "Advice", "pros" => "Pros", "cons" => "Cons", "summary" => "Summary");

    foreach ($text_ratings as $id => $text) {
        echo '
<p><label for="' . $id . '">' . $text . '</label></p>
<textarea id="' . $id . '" name="' . $id . '" required cols="70" rows="5" style="resize: none;"></textarea>
';
    }

    ?>
    </div>
    <div style="width: 50%; display: inline-block; vertical-align: top;">

        <label for="isCurrentJob">Current Job</label>
        <input type="checkbox" id="isCurrentJob" name="isCurrentJob">
        <br><br>
        <label for="jobEndingYear" id="jobEndingYearLabel">Ending year</label>
        <input type="number" id="jobEndingYear" name="jobEndingYear" required min="1900" max="2022" step="1" value="2016">
        <br><br>
        <script>
            $("#jobEndingYear").hide();
            $("#jobEndingYearLabel").hide();
            $("#isCurrentJob").change(function() {

                if ($("#isCurrentJob").is(':checked')) {
                    $("#jobEndingYear").show();
                    $("#jobEndingYearLabel").show();
                } else {
                    $("#jobEndingYear").hide();
                    $("#jobEndingYearLabel").hide();
                }
            });
        </script>

        <label for="employmentStatus">Employment Status</label>
        <select id="employmentStatus" name="employmentStatus" required>
            <option value="NONE">None Selected</option>
            <option value="INTERN">Intern</option>
            <option value="FREELANCE">Freelance</option>
            <option value="CONTRACT">Contract</option>
            <option value="PART_TIME">Part Time</option>
            <option value="REGULAR">Regular</option>
        </select>
        <br><br>
        <label for="jobTitle">Job Title</label>
        <input type="text" id="jobTitle" name="jobTitle" required>
        <br><br>
        <label for="lengthOfEmployment">Length of Employment</label>
        <input type="number" id="lengthOfEmployment" name="lengthOfEmployment" required>
        <br><br>

<?php
    $out_of_5_ratings = array("ratingCareerOpportunities" => "Career Opportunities Rating",
        "ratingCompensationAndBenefits" => "Compensation And Benefits Rating",
        "ratingCultureAndValues" => "Culture And Values Rating",
        "ratingDiversityAndInclusion" => "Diversity And Inclusion Review",
        "ratingOverall" => "Overall Rating",
        "ratingSeniorLeadership" => "Senior Leadership Rating",
        "ratingWorkLifeBalance" => "Work Life Balance Rating");

    foreach ($out_of_5_ratings as $id => $text) {
        echo '
<label for="' . $id . '">' . $text . '</label>
<select id="' . $id . '" name="' . $id . '" required>
    <option value="0">0</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
</select>
<br><br>
';
    }
    ?>

        <label for="ratingCeo">Ceo Rating</label>
        <select id="ratingCeo" name="ratingCeo" required>
            <option value="NO_OPINION">No Opinion</option>
            <option value="APPROVE">Approve</option>
            <option value="DISAPPROVE">Disapprove</option>
        </select>
        <br><br>
        <label for="ratingBusinessOutlook">Business Outlook Rating</label>
        <select id="ratingBusinessOutlook" name="ratingBusinessOutlook" required>
            <option value="NEUTRAL">Neutral</option>
            <option value="NEGATIVE">Negative</option>
            <option value="POSITIVE">Positive</option>
        </select>
        <br><br>
        <label for="ratingRecommendToFriend">Recommend To Friend Rating</label>
        <select id="ratingRecommendToFriend" name="ratingRecommendToFriend" required>
            <option value="NEGATIVE">Negative</option>
            <option value="POSITIVE">Positive</option>
        </select>

    </div>

    <br><br>
    <input type="submit">
    <p id="error_message" style="color: red; display: inline-block; padding-left: 10px;"></p>

</form>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="js/script.js"></script>

<script>
    let employer = null;
    $("#employer_search_box").keyup(function () {
        $("#employer_search_suggestions").html(update_employer_suggestions($("#employer_search_box").val()));
        $("#employer_search_suggestions").show();
        employer = null;
        $("#employer_search_box").removeClass("valid_input");
        $("#employer_search_box").addClass("invalid-input");
    });

    $("#employer_search_suggestions").on('focus', '.suggestion-item', function () {
        $("#employer_search_box").val($(this).text());
    });

    $("#employer_search_suggestions").on("click", '.suggestion-item', function() {
        $("#employer_search_suggestions").hide();
        employer = this.id;
        $("#employer_search_box").removeClass("invalid-input");
        $("#employer_search_box").addClass("valid_input");
    });

    $("form").submit(function(e){
        if (employer === null) {
            e.preventDefault(e);
            $("#error_message").text("Please select a valid employer");
        }
    });
</script>
</body>
</html>
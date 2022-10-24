/* Sends xml request for employers matching the search term
and inserts into the employer_search_suggestions div */
function update_employer_suggestions(search_term) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            $("#employer_search_suggestions").html(this.responseText);
        }
    };
    xhttp.open("GET", "../resources/xmlRequests.php?search="+search_term, true);
    xhttp.send();
}

/* Sends xml requests for reviews for employer and inserts into reviews_table div */
function load_reviews(employer_id, limit) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            $("#reviews_table").append(this.responseText);
        }
    };
    xhttp.open("GET", "../resources/xmlRequests.php?company_reviews="+employer_id+"&limit="+limit, true);
    xhttp.send();
}
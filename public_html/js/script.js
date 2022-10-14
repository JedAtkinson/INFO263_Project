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

function load_reviews(company_name, limit) {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            $("#reviews_table").append(this.responseText);
        }
    };
    xhttp.open("GET", "../resources/xmlRequests.php?company_reviews="+company_name+"&limit="+limit, true);
    xhttp.send();
}
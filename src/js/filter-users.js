/**
 * Created by Tilman on 26.01.2017.
 */

window.onload = filter;

function filter() {
    //Declare Variables
    var input, filter, table, tr, tdname, i;

    input = document.getElementById("searchString");
    filter = input.value.toUpperCase();
    table = document.getElementById("user-table");
    tr = table.getElementsByTagName("tr");

    // Loop through all displayed users, and hide those who don't match the filter criteria
    for (i = 0; i < tr.length; i++) {
        tdname = tr[i].getElementsByTagName("td")[0];
        if (tdname) {
            if (tdname.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

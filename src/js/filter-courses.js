/**
 * Created by Rouchdi on 12/14/2016.
 */

window.onload = filter;

function filter(){

    var input, filter, table, body, tr, tdlang, td, lang, a, dropdown, selected ,i, j,inputs;
    var flag = new Boolean();

    input = document.getElementById("searchString");
    filter = input.value.toUpperCase();
    dropdown = document.getElementById("lang_dropdown");
    selected = dropdown.options[dropdown.selectedIndex].value;
    table = document.getElementById("course-table");
    tr = table.getElementsByTagName("tr");

    // Loop through all displayed courses, and hide those who don't match the filter criteria
    for (i = 0; i < tr.length; i++) {
        flag = false;

        if(selected.localeCompare("all") == 0){
            flag = true;
        }
        else{
            tdlang = tr[i].getElementsByTagName("td")[3];
            if(tdlang){
                input = tdlang.getElementsByTagName("input");
                for(j = 0; j< input.length; j++){
                    if(input[j].value.localeCompare(selected)== 0){
                        flag = true;
                    }
                }
            }
        }

        td = tr[i].getElementsByTagName("td")[0];
        if (td) {

            p = td.getElementsByTagName("p");
            var found_flag = false;

            for(var k = 0; k< p.length; k++){
                if(p[k].innerHTML.toUpperCase().indexOf(filter) > -1){
                    found_flag = true;
                }
            }

            if (found_flag && flag) {
                tr[i].style.display = "";
                tr[i+1].style.display = "";
                i++;
            } else {
                tr[i].style.display = "none";
                tr[i+1].style.display = "none";
                i++;
            }

        }
    }
    sortTable();
}

/*
Source: https://www.w3schools.com/howto/howto_js_sort_table.asp
Adjusted to work with the description row... 
*/
function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("course-table");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = $( ".c" );
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 0; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      if (x.getElementsByTagName("a")[0].innerHTML.toLowerCase() > y.getElementsByTagName("a")[0].innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch= true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      //$(rows[i]).after($(rows[i+1]));
      var i1 = $(rows[i+1]).attr('id');
      var d1 = document.getElementById(i1+"-desc");
      rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
      rows[i].parentNode.insertBefore(d1, rows[i]);
      //rows[i].parentNode.insertBefore(rows[i+3], rows[i]);
      switching = true;
    }
  }
}
/**
 * Created by Rouchdi on 12/14/2016.
 */

//this function is used to filter courses by language
/*function filter()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("course_table").innerHTML=xmlhttp.responseText;
        }
    }

    var filtered = $("#fsearch").serialize();
    xmlhttp.open("POST","../php/filter_course_list.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send(filtered);
}
*/

function filter(){

    var input, filter, table, body, tr, tdlang, td, lang, a, dropdown, selected ,i,j, input,inputs;
    var flag = new Boolean();

    input = document.getElementById("searchString");
    filter = input.value.toUpperCase();
    dropdown = document.getElementById("lang_dropdown");
    selected = dropdown.options[dropdown.selectedIndex].value;
    table = document.getElementById("courseTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all displayed courses, and hide those who don't match the filter criteria
    for (i = 0; i < tr.length; i++) {
        flag = false;

        if(selected.localeCompare("All Courses") == 0){
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
            a = td.getElementsByTagName("a")[0];

            if (a.innerHTML.toUpperCase().indexOf(filter) > -1 && flag) {
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
}
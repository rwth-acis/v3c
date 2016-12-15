/**
 * Created by Rouchdi on 12/14/2016.
 */

//this function is used to filter courses by language
function filter()
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

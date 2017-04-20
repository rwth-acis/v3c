<?php

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], '../media/'.$_POST["type"].'/' . $_FILES['file']['name']);
        echo 'http://virtus-vet.eu/src/media/'.$_POST["type"].'/' . $_FILES['file']['name'];
    }

?>
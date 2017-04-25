<?php

    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $ext;
        // $filename = $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], '../media/'.$_POST["type"].'/' . $filename);
        echo 'http://virtus-vet.eu/src/media/'.$_POST["type"].'/' .  $filename;
    }

?>

<?php
/**
 * Created by PhpStorm.
 * User: jkruijt
 * Date: 16/01/2019
 * Time: 12:27
 */

if (isset($_POST['submit'])) {

    $cid = $_GET['CursusID'];
    $coid = $_GET['CursusonderdeelID'];


    include_once '../../db/db.connect.php';

    $sql = '';

    while ( ($fruit_name = current($_POST)) !== FALSE ) {

        $key = key($_POST);

        $input = mysqli_real_escape_string($conn, $_POST[$key]);


        if ($input != '' && $input !='Submit'){
            $sql .= "INSERT INTO opmerking (veldid, cursusid, cursusonderdeelid, usersid, opmerking) values('$key', '$cid', '$coid', '1', '$input');";
        }

        next($_POST);
    }

    if ($conn->multi_query($sql) === TRUE) {
        echo "New records created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


} else {
    echo 'hell no';
}



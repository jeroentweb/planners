<?php
/**
 * Created by PhpStorm.
 * User: jkruijt
 * Date: 19/12/2018
 * Time: 09:25
 */

if(isset($_POST['VeldID'])||isset($_POST['CursusonderdeelID'])||isset($_POST['CursusID'])||isset($_POST['BedrijfID'])){

//    include van de db
    include_once 'db/db.connect.php';

//    var in laten vullen door de post mehtode van select.ajax.php waar 3 waarders in de td staan
    $veldid = mysqli_real_escape_string($conn, $_POST['VeldID']);
    $coid = mysqli_real_escape_string($conn, $_POST['CursusonderdeelID']);
    $cid = mysqli_real_escape_string($conn, $_POST['CursusID']);
    $bid = mysqli_real_escape_string($conn, $_POST['BedrijfID']);


    $sql = 'select ActiefID from actief where VeldID = '. $veldid .' AND Cursusid = ' . $cid . ' AND Cursusonderdeelid = '. $coid .' AND BedrijfID = '. $bid;

    $result = $conn->query($sql);

    if(mysqli_num_rows($result)==0){

        $add = 'insert into actief(VeldID, Cursusid, Cursusonderdeelid, BedrijfID) values ('.$veldid.','.$cid.', '.$coid.', '.$bid.')';

        $addresult = $conn->query($add);



    }else{

    $delete = 'DELETE FROM actief WHERE VeldID = '.$veldid.' and Cursusid = '.$cid.' and Cursusonderdeelid = '. $coid.' and BedrijfID = '.$bid;

    $deleteresult = $conn->query($delete);

    }
}



<?php
/**
 * Created by PhpStorm.
 * User: jkruijt
 * Date: 31-10-2018
 * Time: 9:09
 */

if (isset($_GET['optie'])) {
    //hier komt de code om de veld waarden voor de titel van de gegevens te halen
    $velden = "SELECT * FROM velden";

    $result = $conn->query($velden);

    while ($row = mysqli_fetch_array($result)) {

        $titels[] = $row;

    }


//         gegevens van de cursus aan hand van 4 parameters als de optie waarden gelijk is aan 0 is
//         en als deze gelijk is aan 1 dan is er geen docentid bekent dus word deze weg gehaald uit $docent
    $optie = $_GET['optie'];


    if ($optie == 0) {


        $cursusid = $_GET['CursusID'];
        $opleidingid = $_GET['OpleidingID'];
        $cursusonderdeel = $_GET['CursusOnderdeelID'];
        $docentid = $_GET['docentid'];

        $docent = 'WHERE P.deleted = 0 AND C.CursusID =' . $cursusid . ' AND C.OpleidingID =' . $opleidingid . ' AND CO.CursusOnderdeelID =' . $cursusonderdeel . ' and D.DocentID = ' . $docentid;

        $opmerking = 'WHERE CursusID = ' . $cursusid . ' AND CursusOnderdeelID = ' . $cursusonderdeel . ' and DocentID = ' . $docentid;

    } elseif ($optie == 1) {

        $cursusid = $_GET['CursusID'];
        $opleidingid = $_GET['OpleidingID'];
        $cursusonderdeel = $_GET['CursusOnderdeelID'];

        $docent = 'WHERE P.deleted = 0 AND C.CursusID =' . $cursusid . ' AND C.OpleidingID =' . $opleidingid . ' AND CO.CursusOnderdeelID =' . $cursusonderdeel;

        $opmerking = 'WHERE C.CursusID =' . $cursusid . ' AND CO.CursusOnderdeelID =' . $cursusonderdeel;

    }

    $Sql = "SELECT OP.Opleidingnaam, O.onderdeelnaam, B.accountname AS Bedrijf, CONCAT(d.Voornaam, \" \", d.Achternaam) AS Docent, date(co.DatumBegin) AS datum, Aantal,
CASE WHEN COL.LocatieID > 0 THEN L.Locatienaam WHEN COL.BedrijfID > 0 THEN B.accountname ELSE \"Geen locatie\" END AS Locatie,
CASE WHEN COL.LocatieID > 0 THEN L.Woonplaats WHEN COL.BedrijfID > 0 THEN BA.ship_city ELSE \"Geen locatie\" END AS Plaats
FROM cursussen C
LEFT JOIN opleidingen OP ON C.OpleidingID = OP.OpleidingID
LEFT JOIN cursusbedrijven CB ON C.CursusID = CB.CursusID
LEFT JOIN vtigercrm600.vtiger_account AS B ON CB.BedrijfID = B.accountid
LEFT JOIN cursusonderdelen CO ON C.CursusID = CO.CursusID
LEFT JOIN onderdelen O ON CO.onderdeelID = O.onderdeelID
LEFT JOIN cursusonderdeeldocenten COD ON CO.CursusOnderdeelID = COD.CursusOnderdeelID
LEFT JOIN cursusonderdeellocaties COL ON CO.CursusOnderdeelID = COL.CursusOnderdeelID
LEFT JOIN (SELECT CursusID, CursusOnderdeelID, COUNT(CursistID) AS Aantal FROM cursusonderdeelcursisten GROUP BY CursusOnderdeelID) COC ON CO.CursusOnderdeelID = COC.CursusOnderdeelID
LEFT JOIN locaties L ON COL.LocatieID = L.LocatieID
LEFT JOIN docenten D ON COD.DocentID = D.DocentID
LEFT JOIN vtigercrm600.vtiger_accountshipads AS BA ON COL.BedrijfID = BA.accountaddressid
LEFT JOIN psentity P ON C.CursusID = P.psid
$docent
";

    $result = $conn->query($Sql);
    while ($row = mysqli_fetch_array($result)) {

        $info = $row;


    }


//      query om de opmerking uit de  database te halen aan hand van de var die boven word in gevuld aan hand van de get methode
//    $opmerking = "SELECT VeldID, UsersID, Opmerking, datum FROM opmerking $opmerking";

    $opmerking = "SELECT VeldID, UsersID, Opmerking, datum, U.voornaam FROM opmerking OPM
LEFT JOIN users U ON OPM.UsersID =  U.userid $opmerking";


    $result = $conn->query($opmerking);
    while ($row = mysqli_fetch_array($result)) {

        $opmerkingen[] = $row;

    }


} else {

    header("location: ./");
    session_destroy();
    exit();

}

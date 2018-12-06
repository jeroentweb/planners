<?php
/**
 * Created by PhpStorm.
 * User: jkruijt
 * Date: 4-10-2018
 * Time: 15:26
 */

if (isset($_GET['CursusID']) || isset($_GET['CursusonderdeelID'])) {
    session_start();




    $cursusid = $_GET['CursusID'];
    $cursusonderdeel = $_GET['CursusonderdeelID'];

//    $where = 'WHERE P.deleted = 0 AND C.CursusID =' . $cursusid . ' AND CO.CursusOnderdeelID =' . $cursusonderdeel;

    $_SESSION['cursusid'] = $cursusid;
    $_SESSION['cursusonderdeelid'] = $cursusonderdeel;

    $Sql = "SELECT C.CursusID, C.OpleidingID, CB.BedrijfID, CO.CursusOnderdeelID, D.DocentID, OP.Opleidingnaam, O.onderdeelnaam, B.accountname AS Bedrijf, CONCAT(d.Voornaam, \" \", d.Achternaam) AS Docent, date(co.DatumBegin) AS datum, COL.LocatieID, COL.BedrijfID, Aantal,
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
WHERE P.deleted = 0 AND C.CursusID = $cursusid  AND CO.CursusOnderdeelID = $cursusonderdeel";

    $result = $conn->query($Sql);
    $info = mysqli_fetch_array($result);

    $sql = "SELECT CB.BedrijfID, D.DocentID, B.accountname 
AS Bedrijf, CONCAT(d.Voornaam, \" \", d.Achternaam) AS Docent, COL.BedrijfID 
FROM cursussen C 
LEFT JOIN cursusbedrijven CB ON C.CursusID = CB.CursusID 
LEFT JOIN vtigercrm600.vtiger_account AS B ON CB.BedrijfID = B.accountid 
LEFT JOIN cursusonderdelen CO ON C.CursusID = CO.CursusID 
LEFT JOIN cursusonderdeeldocenten COD ON CO.CursusOnderdeelID = COD.CursusOnderdeelID 
LEFT JOIN cursusonderdeellocaties COL ON CO.CursusOnderdeelID = COL.CursusOnderdeelID 
LEFT JOIN (SELECT CursusID, CursusOnderdeelID, COUNT(CursistID) AS Aantal FROM cursusonderdeelcursisten GROUP BY CursusOnderdeelID) COC ON CO.CursusOnderdeelID = COC.CursusOnderdeelID 
LEFT JOIN docenten D ON COD.DocentID = D.DocentID 
LEFT JOIN vtigercrm600.vtiger_accountshipads AS BA ON COL.BedrijfID = BA.accountaddressid 
LEFT JOIN psentity P ON C.CursusID = P.psid 
WHERE P.deleted = 0 AND C.CursusID = $cursusid  AND CO.CursusOnderdeelID = $cursusonderdeel";

    $result = $conn->query($sql);

    $docent = '';

    $bedrijf = '';

    $bcheck = '';
    $dcheck = '';

    while ($gegevens = mysqli_fetch_array($result)) {

        if ($dcheck !== $gegevens['Docent']) {
            $dcheck = $gegevens['Docent'];
        } else {

            $dcheck = '';

        }

        $docent .= $dcheck . '<br>';


        if ($bcheck != $gegevens['Bedrijf']) {

            $bcheck = $gegevens['Bedrijf'];

        } else {

            $bcheck = '';

        }

        $bedrijf .= $bcheck . '<br>';

    }


} else {
    header("location: ./");
    session_destroy();
    exit();

}
<?php
/**
 * Created by PhpStorm.
 * User: jkruijt
 * Date: 19/12/2018
 * Time: 16:15
 */

$bgc = '#cccccc';

    $bezig = 'select * from actief where VeldID = ' . $titelids . ' and Cursusid = ' . $cursusid . '  and Cursusonderdeelid = ' . $coid .' and BedrijfID = ' . $bedrijfid;

    $klaar = $conn->query($bezig);

    if (mysqli_num_rows($klaar) > 0) {

        $done = mysqli_fetch_array($klaar);
        $id = $done['VeldID'].$done['Cursusonderdeelid'];


        ?>
        <script>
            $(document).ready(function () {

                $(".<?php echo $id?>").attr("bgcolor", "#ffffff");

            });
        </script>
        <?php

}



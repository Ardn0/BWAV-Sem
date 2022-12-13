<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Styly/indexStyle.css">
    <meta charset="UTF-8">
    <title>Manage Linux computers</title>
</head>
<body>
<nav id="menu">
    <li><a href="prihlasen.php">Moje stroje</a></li>
    <li><a href="#">Ceník</a></li>
    <li><a onclick="popupwindow('upravStroj.php','as',800,500)" href="#">Uprav</a></li>
    <script>
        function popupwindow(url, title, w, h) {
            var left = (screen.width / 2) - (w / 2);
            var top = (screen.height / 2) - (h / 2);
            return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        }
    </script>

</nav>

<?php
require 'Database/dbCon.php';
session_start();

$idStroje = $_SESSION['idStroj'];

$sql = "select * from LINUXMACHINES where ID_STROJE = '$idStroje'";
$stid = oci_parse($c, $sql);
oci_execute($stid);

if (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
    $nazev = $row['JMENO_STROJE'];
    $dis = $row['DISTRIBUCE_STROJE'];
    $ram = $row['POCET_RAM'];
    $ssd = $row['VELIKOST_DISKU'];
    $gpu = $row['GPU_STROJE'];
    $cpu = $row['POCET_CPU'];
}

$randomCisloRam = (rand(0, 10) / 10) + rand(0, $ram - 1);
$randomCisloCPU = rand(0, 100);
$randomCisloSSD = (rand(0, 10) / 10) + rand(0, $ssd - 1);
$randomCisloTeplotaCPU = rand(30, 99);
if ($gpu != "nic") {
    $randomCisloTeplotaGPU = rand(30, 99);
    $randomCisloGPU = rand(0, 100);
} else {
    $randomCisloTeplotaGPU = "---";
    $randomCisloGPU = "---";
    $gpu = "---";
}

?>

<div id="infoStroj">
    <h2><?= $nazev ?></h2>

    <div id="oSys">
        Distribuce: <?= $dis ?> <span id="dist"
                                      style="margin-left: 170px"> Dostupne aktualizace:<?= $_SESSION['aktualizace'] ?> balicku </span>
        <br>
    </div>

    <div id="oHar">
        CPU: <?= $cpu . "/" . $cpu * 2 ?> <span id="dist" style="margin-left: 170px"> GPU: <?= $gpu ?> </span> <br> <br>
        Vyuziti ram: <?= $randomCisloRam ?> GB / <?= $ram ?> GB <span
                id="dist"> Vyuziti CPU: <?= $randomCisloCPU ?>% </span>
        <span id="dist"> Vyuziti GPU: <?= $randomCisloGPU ?>% </span>
        <br>
        Uloziste: <?= $randomCisloSSD ?>GB / <?= $ssd ?>GB <span
                id="dist"> Teplota CPU: <?= $randomCisloTeplotaCPU ?>°C </span>
        <span id="dist"> Teplota GPU: <?= $randomCisloTeplotaGPU ?>°C </span>
    </div>

</div>
<br>
<div id="infoStrojProces">

    <table>
        <tbody>
        <tr>
            <td>PID</td>
            <td>user</td>
            <td>PRI</td>
            <td>NI</td>
            <td>CPU[%]</td>
            <td>MEM[%]</td>
            <td>TIME</td>
            <td>Command</td>
        </tr>
        <tr>
            <td>990</td>
            <td>ondra</td>
            <td>20</td>
            <td>0</td>
            <td>15.3</td>
            <td>10.2</td>
            <td>7:28.91</td>
            <td id="com">/usr/lib/firefox/firefox</td>
        </tr>
        <tr>
            <td>24718</td>
            <td>root</td>
            <td>20</td>
            <td>0</td>
            <td>0.9</td>
            <td>0.1</td>
            <td>0:00.20</td>
            <td id="com">/usr/bin/NetworkManager</td>
        </tr>
        <tr>
            <td>719</td>
            <td>ondra</td>
            <td>19</td>
            <td>-1</td>
            <td>0.7</td>
            <td>0.5</td>
            <td>0:05.81</td>
            <td id="com">/usr/lib/Xorg -nolisten</td>
        </tr>
        <tr>
            <td>627</td>
            <td>ondra</td>
            <td>20</td>
            <td>0</td>
            <td>0.0</td>
            <td>0.1</td>
            <td>0:08.27</td>
            <td id="com">/usr/bin/plasmashell --no-respawn</td>
        </tr>
        <tr>
            <td>1088</td>
            <td>ondra</td>
            <td>19</td>
            <td>-1</td>
            <td>10.1</td>
            <td>5.3</td>
            <td>0:02.53</td>
            <td id="com">/usr/lib/firefox/firefox -contentproc -childID 1</td>
        </tr>
        </tbody>
    </table>
</div>


</body>
</html>
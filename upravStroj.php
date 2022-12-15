<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Styly/indexStyle.css">
    <meta charset="UTF-8">
    <title>Manage Linux computers</title>
</head>
<body>

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

if ($cpu == "2") {
    $cpu2 = "selected";
} elseif ($cpu == "4") {
    $cpu4 = "selected";
} elseif ($cpu == "8") {
    $cpu8 = "selected";
} elseif ($cpu == "16") {
    $cpu16 = "selected";
} elseif ($cpu == "32") {
    $cpu32 = "selected";
} elseif ($cpu == "64") {
    $cpu64 = "selected";
} elseif ($cpu == "128") {
    $cpu128 = "selected";
}

if ($ram == "2") {
    $ram2 = "checked";
} elseif ($ram == "4") {
    $ram4 = "checked";
} elseif ($ram == "8") {
    $ram8 = "checked";
} elseif ($ram == "16") {
    $ram16 = "checked";
} elseif ($ram == "32") {
    $ram32 = "checked";
} elseif ($ram == "64") {
    $ram64 = "checked";
}

if ($ssd == "32" || $ssd - 1024 == "32") {
    $ssd32 = "checked";
    if ($ssd - 1024 == "32" ){
        $hddExtra = "checked";
    }
} elseif ($ssd == "64" || $ssd - 1024 == "64") {
    $ssd64 = "checked";
    if ($ssd - 1024 == "64" ){
        $hddExtra = "checked";
    }
} elseif ($ssd == "128" || $ssd - 1024 == "128") {
    $ssd128 = "checked";
    if ($ssd - 1024 == "128" ){
        $hddExtra = "checked";
    }
} elseif ($ssd == "256" || $ssd - 1024 == "256") {
    $ssd256 = "checked";
    if ($ssd - 1024 == "256" ){
        $hddExtra = "checked";
    }
} elseif ($ssd == "512" || $ssd - 1024 == "512") {
    $ssd512 = "checked";
    if ($ssd - 1024 == "512" ){
        $hddExtra = "checked";
    }
} elseif ($ssd == "1024" || $ssd - 1024 == "1024") {
    $ssd1024 = "checked";
    if ($ssd - 1024 == "1024" ){
        $hddExtra = "checked";
    }
}

if ($gpu == "1080") {
    $gpu1 = "checked";
} elseif ($gpu == "2080") {
    $gpu2 = "checked";
} elseif ($gpu == "6500") {
    $gpu3 = "checked";
} elseif ($gpu == "6750xt") {
    $gpu4 = "checked";
} elseif ($gpu == "nic") {
    $gpu5 = "checked";
}


oci_close($c)
?>
<form method="post" id="centerAdd">
    Název stroje: <input type="text" name="vmName" value=<?= $nazev ?>> <br>
    CPU:<select name="cpu">
        <option value="2" <?= $cpu2 ?>>2</option>
        <option value="4" <?= $cpu4 ?>>4</option>
        <option value="8" <?= $cpu8 ?>>8</option>
        <option value="16" <?= $cpu16 ?>>16</option>
        <option value="32" <?= $cpu32 ?>>32</option>
        <option value="64" <?= $cpu64 ?>>64</option>
        <option value="128" <?= $cpu128 ?>>128</option>
    </select> <br>
    RAM: <input type="radio" name="ram" value="2" <?= $ram2 ?>> 2 GB
    <input type="radio" name="ram" value="4" <?= $ram4 ?>> 4 GB
    <input type="radio" name="ram" value="8" <?= $ram8 ?>> 8 GB
    <input type="radio" name="ram" value="16" <?= $ram16 ?>> 16 GB
    <input type="radio" name="ram" value="32" <?= $ram32 ?>> 32 GB
    <input type="radio" name="ram" value="64" <?= $ram64 ?>> 64 GB
    <br>

    SSD: <input type="radio" name="ssd" value="32" <?= $ssd32 ?>> 32 GB
    <input type="radio" name="ssd" value="64" <?= $ssd64 ?>> 64 GB
    <input type="radio" name="ssd" value="128" <?= $ssd128 ?>> 128 GB
    <input type="radio" name="ssd" value="256" <?= $ssd256 ?>> 256 GB
    <input type="radio" name="ssd" value="512" <?= $ssd512 ?>> 512 GB
    <input type="radio" name="ssd" value="1024" <?= $ssd1024 ?>> 1024 GB
    <br>
    <input type="checkbox" name="extra" value="1000" <?= $hddExtra?>> + 1TB HDD
    <br>
    GPU: <input type="radio" name="gpu" value="1080" <?= $gpu1 ?>> Geforce GTX 1080
    <input type="radio" name="gpu" value="2080" <?= $gpu2 ?>> Geforce RTX 2080
    <input type="radio" name="gpu" value="6500" <?= $gpu3 ?>> Radeon 6500
    <input type="radio" name="gpu" value="6750xt" <?= $gpu4 ?>> Radeon 6750XT
    <input type="radio" name="gpu" value="nic" <?= $gpu5 ?>> Nic
    <br><br>
    <button type="submit" name="add">Uprav</button>
    <?php
    session_start();
    include 'Database/dbCon.php';
    $jmeno = $_POST['vmName'];
    $dis = $_POST['dis'];
    $cpu = $_POST['cpu'];
    $ram = $_POST['ram'];
    $ssd = $_POST['ssd'];
    $gpu = $_POST['gpu'];
    $hdd = $_POST['extra'];

    if ($hdd != ""){
        $ssd = 1024 + $ssd;
    }

    $idUz = $_SESSION['id'];

    $sql = "update LINUXMACHINES SET JMENO_STROJE = '" . $jmeno . "' , POCET_CPU = '" . $cpu . "',POCET_RAM = '" . $ram . "',VELIKOST_DISKU = '" . $ssd . "',GPU_STROJE = '" . $gpu . "' where ID_STROJE = $idStroje";
    $stid = oci_parse($c, $sql);
    if (oci_execute($stid)) {
        ?>

        <script>
            <?php header("Refresh:0; url=info.php"); ?>
            self.close();
        </script>
        <?php
    }
    oci_close($c);
    ?>
</form>

</body>
</html>
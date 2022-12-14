<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Styly/indexStyle.css">
    <meta charset="UTF-8">
    <title>Manage Linux computers</title>
</head>
<body>
<form method="post" id="centerAdd">
    Název stroje: <input type="text" name="vmName"> <br>
    Distribuce: <select name="dis">
        <option value="Arch">Arch</option>
        <option value="Debian">Debian</option>
        <option value="Fedora">Fedora</option>
        <option value="Kali">Kali</option>
        <option value="Ubuntu">Ubuntu</option>
        <option value="PopOs">PopOs</option>
        <option value="Gentoo">Gentoo</option>
    </select> <br>
    CPU:<select name="cpu">
        <option value="2">2</option>
        <option value="4">4</option>
        <option value="8">8</option>
        <option value="16">16</option>
        <option value="32">32</option>
        <option value="64">64</option>
        <option value="128">128</option>
    </select> <br>
    RAM: <input type="radio" name="ram" value="2"> 2 GB
    <input type="radio" name="ram" value="4"> 4 GB
    <input type="radio" name="ram" value="8"> 8 GB
    <input type="radio" name="ram" value="16"> 16 GB
    <input type="radio" name="ram" value="32"> 32 GB
    <input type="radio" name="ram" value="64"> 64 GB
    <br>

    SSD: <input type="radio" name="ssd" value="32"> 32 GB
    <input type="radio" name="ssd" value="64"> 64 GB
    <input type="radio" name="ssd" value="128"> 128 GB
    <input type="radio" name="ssd" value="256"> 256 GB
    <input type="radio" name="ssd" value="512"> 512 GB
    <input type="radio" name="ssd" value="1024"> 1024 GB
    <br>
    <input type="checkbox" name="extra"> + 1TB HDD
    <br>
    GPU: <input type="radio" name="gpu" value="1080"> Geforce GTX 1080
    <input type="radio" name="gpu" value="2080"> Geforce RTX 2080
    <input type="radio" name="gpu" value="6500"> Radeon 6500
    <input type="radio" name="gpu" value="6750xt"> Radeon 6750XT
    <input type="radio" name="gpu" value="nic"> Nic
    <br><br>
    <button type="submit" name="add">Pridej</button>
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

    $ssd = $ssd + $hdd;
    $idUz = $_SESSION['id'];


    $sql = "insert into LINUXMACHINES(JMENO_STROJE, BEZI, POCET_CPU, POCET_RAM, VELIKOST_DISKU, DISTRIBUCE_STROJE, GPU_STROJE, UZIVATEL_ID, CLOUD) values ('" . $jmeno . "','" . 0 . "','" . $cpu . "','" . $ram . "','" . $ssd . "','" . $dis . "','" . $gpu . "','" . $idUz . "','" . 0 . "')";
    $stid = oci_parse($c, $sql);
    if (oci_execute($stid)) {
        ?>

        <script>
            self.close();
        </script>
        <?php
    }
    oci_close($c)
    ?>
</form>

</body>
</html>
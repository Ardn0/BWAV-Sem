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
    <li><a onclick="popupwindow('pridejStroj.php','as',800,500)" href="#">Vytvor</a></li>
    <script>
        function popupwindow(url, title, w, h) {
            var left = (screen.width / 2) - (w / 2);
            var top = (screen.height / 2) - (h / 2);
            return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        }
    </script>

</nav>

<div id="strojeDiv">
    Lokalní virtuální stroje: <br> <br>
    <?php
    require 'Database/dbCon.php';
    session_start();

    $_SESSION['aktualizace'] = rand(0, 120);
    $idUz = $_SESSION['id'];

    $sql = "SELECT * FROM LINUXMACHINES where UZIVATEL_ID = '$idUz'";
    $stid = oci_parse($c, $sql);
    oci_execute($stid);

    if (($row = oci_fetch_array($stid, OCI_ASSOC)) == false) {
        echo "Nemáte žádné virtuální stroje";
    }
    oci_execute($stid);

    while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
        if ($row['BEZI'] == 1) {
            $stavStroje = "Zapnuto";
            $barvaStav = "green";
            $tlacitko = "Vypnout";

        } else {
            $stavStroje = "Vypnuto";
            $barvaStav = "red";
            $tlacitko = "Zapnout";
        }
        $idStroje = $row['ID_STROJE'];
        echo " <div id='stroj'><form method='post'><div id='nazev'>Název: " . $row['JMENO_STROJE'] . "<br> Distribuce: " . $row['DISTRIBUCE_STROJE'] . " </div> <div id='stav' style='color: $barvaStav' > <span>Stav:</span> " . $stavStroje . "</div> <div id='datum'>Datum spuštění: " . $row['DATUM_SPUSTENI'] . "</div> <br> <button style='margin-left: 15px; margin-top: 5px' name='tlacitko' value='$idStroje'>$tlacitko</button> <button id='datum' style='margin-right: 15px; margin-top: 5px' name='info' value='$idStroje'>Více info</button></form> </div>";
    }

    if (isset($_POST['tlacitko'])) {
        $idStroje = $_POST['tlacitko'];
        $datum = date('d-M-Y');

        $sql = "select BEZI from LINUXMACHINES where ID_STROJE = '$idStroje'";
        $stid = oci_parse($c, $sql);
        oci_execute($stid);

        if (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            if ($row['BEZI'] == 1) {
                $bezi = 0;
                $sql = "update LINUXMACHINES SET BEZI = '$bezi' where ID_STROJE = '$idStroje'";
            } else {
                $bezi = 1;
                $sql = "update LINUXMACHINES SET BEZI = '$bezi', DATUM_SPUSTENI = '$datum' where ID_STROJE = '$idStroje'";
            }
        }


        $stid = oci_parse($c, $sql);
        oci_execute($stid);

        header('Location: ?');
    }

    if (isset($_POST['info'])) {
        $_SESSION['idStroj'] = $_POST['info'];
        header('Location: info.php');
    }

    oci_close($c);
    ?>
</div>

<div id="strojeDiv" style="margin-top: auto">
    Cloudové virtuální stroje: <br> <br>
    <?php
    require 'Database/dbCon.php';
    session_start();

    $_SESSION['aktualizace'] = rand(0, 120);
    $idUz = $_SESSION['id'];

    $sql = "SELECT * FROM LINUXMACHINES where UZIVATEL_ID = 22";
    $stid = oci_parse($c, $sql);
    oci_execute($stid);

    if (($row = oci_fetch_array($stid, OCI_ASSOC)) == false) {
        echo "Nemáte žádné virtuální stroje";
    }
    oci_execute($stid);

    while (($row = oci_fetch_array($stid, OCI_ASSOC))) {
        if ($row['BEZI'] == 1) {
            $stavStroje = "Zapnuto";
            $barvaStav = "green";
            $tlacitko = "Vypnout";

        } else {
            $stavStroje = "Vypnuto";
            $barvaStav = "red";
            $tlacitko = "Zapnout";
        }
        $idStroje = $row['ID_STROJE'];
        echo " <div id='stroj'><form method='post'><div id='nazev'>Název: " . $row['JMENO_STROJE'] . "<br> Distribuce: " . $row['DISTRIBUCE_STROJE'] . " </div> <div id='stav' style='color: $barvaStav' > <span>Stav:</span> " . $stavStroje . "</div> <div id='datum'>Datum spuštění: " . $row['DATUM_SPUSTENI'] . "</div> <br> <button style='margin-left: 15px; margin-top: 5px' name='tlacitko' value='$idStroje'>$tlacitko</button> <button id='datum' style='margin-right: 15px; margin-top: 5px' name='info' value='$idStroje'>Více info</button></form> </div>";
    }

    if (isset($_POST['tlacitko'])) {
        $idStroje = $_POST['info'];
        $datum = date('d-M-Y');

        $sql = "select BEZI from LINUXMACHINES where ID_STROJE = '$idStroje'";
        $stid = oci_parse($c, $sql);
        oci_execute($stid);

        if (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            if ($row['BEZI'] == 1) {
                $bezi = 0;
                $sql = "update LINUXMACHINES SET BEZI = '$bezi' where ID_STROJE = '$idStroje'";
            } else {
                $bezi = 1;
                $sql = "update LINUXMACHINES SET BEZI = '$bezi', DATUM_SPUSTENI = '$datum' where ID_STROJE = '$idStroje'";
            }
        }


        $stid = oci_parse($c, $sql);
        oci_execute($stid);

        header('Location: ?');
    }

    if (isset($_POST['info'])) {
        $_SESSION['idStroj'] = $_POST['info'];
        header('Location: info.php');
    }

    oci_close($c);
    ?>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Styly/indexStyle.css">
    <meta charset="UTF-8">
    <title>Manage Linux computers</title>
</head>
<body>
<div id="divMenu">
    <nav id="menu">
        <li><a href="prihlasen.php">Moje stroje</a></li>
        <li><a onclick="popupwindow('pridejStroj.php','as',800,500)" href="#">Vytvoř stroj</a></li>
        <li><a href="index.php">Odhlášení</a> </li>
        <script>
            function popupwindow(url, title, w, h) {
                var left = (screen.width / 2) - (w / 2);
                var top = (screen.height / 2) - (h / 2);
                return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            }
        </script>

    </nav>
</div>


<div id="strojeDiv">
    <h3>Lokalní virtuální stroje:</h3> <br>
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
        echo " <div id='stroj'><form method='post'><div id='nazev'><span style='font-weight: bold'> Název: </span> " . $row['JMENO_STROJE'] . "<br> Distribuce: " . $row['DISTRIBUCE_STROJE'] . " </div> <div id='stav' style='color: $barvaStav' > <span style='font-weight: bold'>Stav:</span> " . $stavStroje . "</div> <div id='datum'><span style='font-weight: bold'>Datum spuštění:</span> " . $row['DATUM_SPUSTENI'] . "</div> <br> <button style='margin-left: 15px; margin-top: 10px; float: left' name='tlacitko' value='$idStroje'>$tlacitko</button> <button id='datum' style='margin-right: 15px; margin-top: 10px' name='info' value='$idStroje'>Více info</button></form> </div>";
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

    <?php
    if ($_SESSION['jmeno'] != "cloud") {
        require 'Database/dbCon.php';
        session_start();

        $_SESSION['aktualizace'] = rand(0, 120);
        $idUz = $_SESSION['id'];

        $sql = "select ID_UZIVATEL from MACHINES_USERS where JMENO_UZIVATELE='cloud'";
        $stid = oci_parse($c, $sql);
        oci_execute($stid);
        $row = oci_fetch_array($stid, OCI_ASSOC);
        $idCloud = $row['ID_UZIVATEL'];

        $sql = "SELECT * FROM LINUXMACHINES where UZIVATEL_ID = $idCloud";
        $stid = oci_parse($c, $sql);
        oci_execute($stid);


        echo "<div id='strojeDiv' style='margin-top: auto'> <h3>Cloudové virtuální stroje:</h3>";

        if (($row = oci_fetch_array($stid, OCI_ASSOC)) == false) {
            echo "Admin nevytvořil žádné virtuální stroje";
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
            echo "<div id='stroj'><form method='post'><div id='nazev'><span style='font-weight: bold'> Název: </span> " . $row['JMENO_STROJE'] . "<br> Distribuce: " . $row['DISTRIBUCE_STROJE'] . " </div> <div id='stav' style='color: $barvaStav' > <span style='font-weight: bold'>Stav:</span> " . $stavStroje . "</div> <div id='datum'><span style='font-weight: bold'>Datum spuštění:</span> " . $row['DATUM_SPUSTENI'] . "</div> <br> <button style='margin-left: 15px; margin-top: 10px; float: left' name='tlacitko' value='$idStroje'>$tlacitko</button> <button id='datum' style='margin-right: 15px; margin-top: 10px' name='info' value='$idStroje'>Více info</button></form> </div>";
        }

        echo"</div>";

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
    }
    ?>

</body>
</html>
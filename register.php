<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Styly/indexStyle.css">
    <meta charset="UTF-8">
    <title>Manage Linux computers</title>
</head>
<body>
<form method="post" id="center" style="width: 20%;">
    Nové jméno: <input type="text" name="userName" style="margin: 5px"> <br>
    Nové heslo: <input type="password" name="password" style="margin: 5px"> <br>
    <button type="submit" name="registrace" style="font-size: 15px; margin-top: 10px">Vytvořit</button>
    <button name="zpatky" style="font-size: 15px; margin-top: 10px">Zpět</button>

    <?php
    require 'Database/dbCon.php';
    $jmenoUz = $_POST['userName'];
    $hesloUz = $_POST['password'];


    $sql = "SELECT ID_UZIVATEL FROM MACHINES_USERS where JMENO_UZIVATELE = '$jmenoUz'";
    $stid = oci_parse($c, $sql);

    oci_execute($stid);

    if (isset($_POST['registrace'])) {

        if (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
           echo "Uživatelské jméno už existuje";
        } else {
            $sql = "insert into MACHINES_USERS(JMENO_UZIVATELE, HESLO_UZIVATEL, PRIHLASEN) values ('" . $jmenoUz . "','" . $hesloUz . "',0) ";
            $stid = oci_parse($c, $sql);
            oci_execute($stid);
            oci_close($c);
            header("Location:index.php");
        }
    }

    if (isset($_POST['zpatky'])) {
        header("Location: index.php");
    }
    ?>
</form>


</body>
</html>
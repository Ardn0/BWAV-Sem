<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="Styly/indexStyle.css">
    <meta charset="UTF-8">
    <title>Manage Linux computers</title>
</head>
<body>
<form method="post">
    Jmeno: <input type="text" name="userName"> <br>
    Heslo: <input type="password" name="password"> <br>
    <button type="submit" name="login">Login</button>
    <?php
    require 'Database/dbCon.php';
    $jmenoUz = $_POST['userName'];
    $hesloUz = $_POST['password'];
    session_start();
    $_SESSION['jmeno'] = $jmenoUz;
    $_SESSION['heslo'] = $hesloUz;


    $sql = "SELECT ID_UZIVATEL FROM MACHINES_USERS where JMENO_UZIVATELE = '$jmenoUz' and HESLO_UZIVATEL = '$hesloUz'";
    $stid = oci_parse($c, $sql);

    oci_execute($stid);

    if (isset($_POST['login'])) {

        if (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
            $_SESSION['id'] = $row['ID_UZIVATEL'];
            $jmenoUz = "";
            $hesloUz = "";
            header("Location:prihlasen.php");
        } else {
            echo "Spatne udaje";
        }
    }
    oci_close($c);
    ?>
</form>


</body>
</html>
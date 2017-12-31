<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak eTiket TONAMPTN 2018</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<?php
    $PATH_LOGO_SBS = "res/logo_sbs.jpg";
    $PATH_LOGO_SETYAKI ="res/logo_setyaki.png";
?>
<div id="main_container">
    <h1>TONAMPTN 2018</h1>
    <h3>"Tryout Nasional Masuk Perguruan Tinggi Negeri 2018"</h3>

    <div id="tiket_form">
        <img id="logo_sbs" src="<?php echo $PATH_LOGO_SBS ?>"/>
        <h3>KODE TIKET</h3>
        <form method="post" action="card.php">
            <input type="text" name="kode_tiket"/>
            </br>
            <input type="submit" value="SUBMIT" />
        </form>
    </div>

    <h5>Organized by Setyaki</h5>
    <img id="logo_setyaki" src="<?php echo $PATH_LOGO_SETYAKI ?>"/>
</div>
</body>
</html>
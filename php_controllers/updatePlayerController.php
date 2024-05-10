<?php
require_once('../php_librarys/bd.php');

if(isset($_POST['update'])) {
    // Manejo de la imagen del jugador
    $playerImage = null;
    if(isset($_FILES['playerImage']) && $_FILES['playerImage']['error'] === UPLOAD_ERR_OK) {
        $imagen_temporal = $_FILES['playerImage']['tmp_name'];
        $nombre_imagen = $_FILES['playerImage']['name'];
        $ruta_imagen = '../../collection/images/playersImages/' . $nombre_imagen;
        move_uploaded_file($imagen_temporal, $ruta_imagen);
        $playerImage = $ruta_imagen; // Establecer la ruta completa de la imagen
    }

    updatePlayers($_POST['playerID'], $_POST['teamID'], $_POST['playerName'], $_POST['nationalityID'], $_POST['positionID'], $_POST['heightID'], $playerImage, $_POST['rating']);

    header('Location: ../yourTeam.php');
    exit();
} else {
    echo 'error';
}
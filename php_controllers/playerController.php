<?php
require_once('../php_librarys/bd.php');

if(isset($_POST['insert'])) {
    // Manejo de la imagen del jugador
    $playerImage = null;
    if(isset($_FILES['playerImage']) && $_FILES['playerImage']['error'] === UPLOAD_ERR_OK) {
        $playerImage = $_FILES['playerImage']['tmp_name'];
    }

    insertPlayer($_POST['teamID'], $_POST['playerName'], $_POST['nationalityID'], $_POST['positionID'], $_POST['heightID'], $_POST['playerImage'], $_POST['rating']);

    header('Location: ../yourTeam.php');
    exit();
} 



elseif(isset($_POST['delete'])) {
    deletePlayer($_POST['playerID']);

    header('Location: ../yourTeam.php');
    exit();
}

else {
    echo 'error';
}

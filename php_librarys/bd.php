<?php 

session_start();

function errorMessage($e)
{
    if (!empty($e->errorInfo[1]))
    {
        switch ($e->errorInfo[1])
        {
            case 1062:
                $message = 'Duplicated record';
                break;
            case 1451:
                $message = 'Record with related elements';
                break;
            case 1048:
                $message = 'This player already exists';
                break;
            default:
                $message = $e->errorInfo[1] . ' - ' . $e->errorInfo[2];
                break;
        }
    }
}

function openBd() {
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    
    $conexion = new PDO("mysql:host=$servername;dbname=premierleaguecardcollection", $username, $password);
    // set the PDO error mode to exception
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("set names utf8");

    return $conexion;
}

function closeBd($conexion) {
    $conexion = null;
}

function selectTeams() {
    $conexion = openBd();

    $sentenciaText = "SELECT * FROM premierleaguecardcollection.teams";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    closeBd($conexion);

    return $resultado;
}

function selectPositions() {
    $conexion = openBd();

    $sentenciaText = "SELECT * FROM premierleaguecardcollection.positions";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    closeBd($conexion);

    return $resultado;
}

function selectHeights() {
    $conexion = openBd();

    $sentenciaText = "SELECT * FROM premierleaguecardcollection.heights";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    closeBd($conexion);

    return $resultado;
}

function selectNationalities() {
    $conexion = openBd();

    $sentenciaText = "SELECT * FROM premierleaguecardcollection.nationalities";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    closeBd($conexion);

    return $resultado;
}

function selectRatings() {
    $conexion = openBd();

    $sentenciaText = "SELECT * FROM premierleaguecardcollection.ratings";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    closeBd($conexion);

    return $resultado;
}


function insertPlayer($teamID, $playerName, $nationalityID, $positionID, $heightID, $playerImage, $rating) {
    $conexion = openBd();

    $imagen_temporal = $_FILES['playerImage']['tmp_name'];
    $nombre_imagen = $_FILES['playerImage']['name'];
    $ruta_imagen = '../../collection/images/playersImages/' . $nombre_imagen;

    // Mover la imagen al directorio de destino
    move_uploaded_file($imagen_temporal, $ruta_imagen);

    $rating--;

    // Insertar jugador con los IDs obtenidos
    $sentenciaText = "INSERT INTO premierleaguecardcollection.players (teamID, playerName, nationalityID, positionID, heightID, playerImage, rating) VALUES (:teamID, :playerName, :nationalityID, :positionID, :heightID, :playerImage, :rating)";
    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->bindParam(':teamID', $teamID);
    $sentencia->bindParam(':playerName', $playerName);
    $sentencia->bindParam(':nationalityID', $nationalityID);
    $sentencia->bindParam(':positionID', $positionID);
    $sentencia->bindParam(':heightID', $heightID);
    $sentencia->bindParam(':playerImage', $ruta_imagen);
    $sentencia->bindParam(':rating', $rating);
    $sentencia->execute();

    closeBd($conexion);
}


function selectPlayers() {
    $conexion = openBd();

    $sentenciaText = "SELECT 
                            players.playerID,
                            teams.teamShieldImage,
                            players.playerName,
                            nationalities.nationalityImage,
                            positions.positionName,
                            heights.heightInMeters,
                            players.playerImage,
                            players.rating
                        FROM 
                            players
                        JOIN 
                            teams ON players.teamID = teams.teamID
                        JOIN 
                            nationalities ON players.nationalityID = nationalities.nationalityID
                        JOIN 
                            positions ON players.positionID = positions.positionID
                        JOIN 
                            heights ON players.heightID = heights.heightID;";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetchAll();

    closeBd($conexion);

    return $resultado;
}

function selectGoalKeepers() {
    $conexion = openBd();

    $sentenciaText = "SELECT 
                            players.playerID,
                            teams.teamShieldImage,
                            players.playerName,
                            nationalities.nationalityImage,
                            positions.positionName,
                            heights.heightInMeters,
                            players.playerImage,
                            players.rating
                        FROM 
                            players
                        JOIN 
                            teams ON players.teamID = teams.teamID
                        JOIN 
                            nationalities ON players.nationalityID = nationalities.nationalityID
                        JOIN 
                            positions ON players.positionID = positions.positionID
                        JOIN 
                            heights ON players.heightID = heights.heightID
                        WHERE 
                            positions.positionName = 'Goalkeeper'";

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

    closeBd($conexion);

    return $resultado;
}

function selectDefenders() {
    $conexion = openBd();

    $sentenciaText = "SELECT 
                            players.playerID,
                            teams.teamShieldImage,
                            players.playerName,
                            nationalities.nationalityImage,
                            positions.positionName,
                            heights.heightInMeters,
                            players.playerImage,
                            players.rating
                        FROM 
                            players
                        JOIN 
                            teams ON players.teamID = teams.teamID
                        JOIN 
                            nationalities ON players.nationalityID = nationalities.nationalityID
                        JOIN 
                            positions ON players.positionID = positions.positionID
                        JOIN 
                            heights ON players.heightID = heights.heightID
                        WHERE 
                            positions.positionName = 'Defender'
                            
                        ORDER BY playerID DESC
                        LIMIT 4";
                            

    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->execute();

    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

    closeBd($conexion);

    return $resultado;
}

function updatePlayers($playerID, $teamID, $playerName, $nationalityID, $positionID, $heightID, $playerImage, $rating) {
    $conexion = openBd();

    if (!empty($playerImage['tmp_name'])) {
        $imagen_temporal = $playerImage['tmp_name'];
        $nombre_imagen = $playerImage['name'];
        $ruta_imagen = '../../collection/images/playersImages/' . $nombre_imagen;
        move_uploaded_file($imagen_temporal, $ruta_imagen);
    } else {
        $ruta_imagen = $playerImage;
    }

    $rating--;

    $sentenciaText = "UPDATE premierleaguecardcollection.players
                      SET teamID = :teamID, 
                          playerName = :playerName, 
                          nationalityID = :nationalityID, 
                          positionID = :positionID, 
                          heightID = :heightID, 
                          playerImage = :playerImage, 
                          rating = :rating 
                      WHERE playerID = :playerID";
    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->bindParam(':teamID', $teamID);
    $sentencia->bindParam(':playerName', $playerName);
    $sentencia->bindParam(':nationalityID', $nationalityID);
    $sentencia->bindParam(':positionID', $positionID);
    $sentencia->bindParam(':heightID', $heightID);
    $sentencia->bindParam(':playerImage', $ruta_imagen);
    $sentencia->bindParam(':rating', $rating);
    $sentencia->bindParam(':playerID', $playerID);
    $sentencia->execute();

    closeBd($conexion);
}

function deletePlayer($playerID) {
    $conexion = openBd();

    $sentenciaText = "DELETE FROM premierleaguecardcollection.players WHERE playerID = :playerID";
    $sentencia = $conexion->prepare($sentenciaText);
    $sentencia->bindParam(':playerID', $playerID);
    $sentencia->execute();

    closeBd($conexion);
}

<?php
    require_once('./php_librarys/bd.php');

    $teams = selectTeams();
    $positions = selectPositions();
    $heights = selectHeights();
    $nationalities = selectNationalities();
    $ratings = selectRatings();
    $players = selectPlayers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@100;200;300;400;500;600;700;800;900&family=VT323&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css\style.css">
    <title>Edit Player</title>
    <link rel="icon" href="favicon.ico" type="image/png">
</head>
<body>
    
            <div class="modal-content">
                <div id="edit-form">
                    <div class="card" id="edit-card">
                        <div class="cardColor"></div>
                        <div class="badge">
                            <img src="<?= $_POST['teamShieldImage']; ?>" alt="Team Shield" class="teamShield">
                        </div>
                        <div class="playerImageContainer">
                            <img src="<?= $_POST['playerImage']; ?>" alt="Player Image" class="playerImage">
                        </div>
                        <div class="topInfo">
                            <div class="playerNationality">
                                <img src="<?= $_POST['nationalityImage']; ?>" alt="National Flag" class="flag-img">
                            </div>
                            <div class="playerPosition"><?php echo $_POST['positionName']; ?></div>
                            <div class="playerHeight"><?php echo $_POST['heightInMeters']; ?></div>
                        </div>
                        <div class="playerName"><?php echo $_POST['playerName']; ?></div>
                        <div class="blankPuntuationFrame">
                            <div class="blankPuntuation">
                                <?php echo $_POST['rating']; ?>
                            </div>
                        </div>
                    </div>

                    <form action="./php_controllers/updatePlayerController.php" method="POST" enctype="multipart/form-data"
                        style="
                            position: absolute;
                            right: 0;
                            margin-right: 40px;"
                    >
                        <div class="form-floating">   
                            <div id="form-floating-1">   
                                <input type="hidden" name="playerID" value="<?php echo $_POST['playerID']; ?>">       
                                
                                <input type="text" name="playerName" id="playerNameInput" value="<?php echo $_POST['playerName'];?>" placeholder="<?php echo $_POST['playerName'];?>">
                                <br>

                                <select name="teamID" id="teamSelect" class="form-control">
                                    <option value="">Select a Team</option>
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?php echo $team["teamID"]; ?>"><?php echo $team["teamName"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <br>

                                <select name="nationalityID" id="nationalitySelect">
                                    <option value="">Select the Country</option>
                                    <?php foreach ($nationalities as $nationality): ?>
                                        <option value="<?= $nationality["nationalityID"]; ?>"><?= $nationality["nationalityName"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <br>

                                <input type="file" name="playerImage" id="playerImage" style="display:none;">
                                <label for="playerImage" id="playerImage-placeholder">Upload a player image</label>
                                <br>
                            </div>

                            <div id="form-floating-2">
                                <select name="positionID" id="positionSelect">
                                    <option value="">Select the Position</option>
                                    <?php foreach ($positions as $position): ?>
                                        <option value="<?= $position["positionID"]; ?>"><?= $position["positionName"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <br>

                                <select name="heightID" id="heightSelect" class="form-control">
                                    <option value="">Select the Height</option>
                                    <?php foreach ($heights as $height): ?>
                                        <option value="<?= $height["heightID"]; ?>"><?= $height["heightInMeters"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <br>

                                <select name="rating" id="puntuationSelect" class="form-control">
                                    <option value="">Select the Rating</option>
                                    <?php foreach ($ratings as $rating): ?>
                                        <option value="<?php echo $rating["ratingID"]; ?>"><?php echo $rating["score"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <br>

                                <button type="submit" name="update" id="edit-player-button">Editar jugador</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

</body>
</html>
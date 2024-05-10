<?php
    require_once('./php_librarys/bd.php');

    $teams = selectTeams();
    $positions = selectPositions();
    $heights = selectHeights();
    $nationalities = selectNationalities();
    $ratings = selectRatings();
    $players = selectPlayers();
    $goalKeeper = selectGoalKeepers();
    $defenders = selectDefenders();
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
    <title>Your Team</title>
    <link rel="icon" href="favicon.ico" type="image/png">
</head>

<body>

<div class="superior-menu">
    <a href="index.php">
        <button class="btn btn-primary" id="backButton">
            <img src="images/ion_arrow-undo-sharp.png" alt="">
        </button>
    </a>

    <h1 class="your-team-name">Your Team</h1>

    <button class="btn btn-primary" data-toggle="modal" data-target="#addPlayerModal" id="addPlayerButton">
        <p class="addPlayerText">Add Player</p>
    </button>
</div>

<div class="cards-container">
    <?php foreach ($players as $player): ?>
        <div class="card">
            <div class="cardColor"></div>
            <div class="badge">
                <img src="<?= $player['teamShieldImage']; ?>" alt="Team Shield" class="teamShield">
            </div>
            <div class="playerImageContainer">
                <img src="<?= $player['playerImage']; ?>" alt="Player Image" class="playerImage">
            </div>
            <div class="topInfo">
                <div class="playerNationality">
                    <img src="<?= $player['nationalityImage']; ?>" alt="National Flag" class="flag-img">
                </div>
                <div class="playerPosition"><?php echo $player['positionName']; ?></div>
                <div class="playerHeight"><?php echo $player['heightInMeters'];?>m</div>
            </div>
            <div class="playerName"><?php echo $player['playerName']; ?></div>
            <div class="blankPuntuationFrame">
                <div class="blankPuntuation">
                    <?php echo $player['rating']; ?>
                </div>
            </div>
                
                <div class="buttons-container">
                <form action="editPlayer.php" method="POST">
                    <input type="hidden" name="playerID" value="<?php echo $player['playerID']; ?>">
                    <input type="hidden" name="teamShieldImage" value="<?php echo $player['teamShieldImage']; ?>">
                    <input type="hidden" name="playerName" value="<?php echo $player['playerName']; ?>">
                    <input type="hidden" name="nationalityImage" value="<?php echo $player['nationalityImage']; ?>">
                    <input type="hidden" name="positionName" value="<?php echo $player['positionName']; ?>">
                    <input type="hidden" name="heightInMeters" value="<?php echo $player['heightInMeters']; ?>">
                    <input type="hidden" name="playerImage" value="<?php echo $player['playerImage']; ?>">
                    <input type="hidden" name="rating" value="<?php echo $player['rating']; ?>">
                    <input type="hidden" name="teamID" value="<?php echo $team['teamID']; ?>"> 
                    <input type="hidden" name="teamName" value="<?php echo $team['teamName']; ?>">
                    <input type="hidden" name="nationalityID" value="<?php echo $nationality['nationalityID']; ?>">
                    <input type="hidden" name="nationalityName" value="<?php echo $nationality['nationalityName']; ?>">
                    <input type="hidden" name="positionID" value="<?php echo $position['positionID']; ?>">
                    

                    <button type="submit" class="btn btn-primary edit-button" id="updatePlayerButton">Edit</button>
                </form>

                    <form action="./php_controllers/playerController.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="playerID" value="<?php echo $player['playerID']; ?>">  
                        <button type="submit" class="btn btn-danger delete-button" name="delete" id="deletePlayerButton">Delete</button>
                    </form>
                </div>
            
        </div>
    <?php endforeach; ?>
</div>

    <div class="modal fade" id="addPlayerModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                

                <div class="addPlayerWindow">        
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-label="Close" id="close-create-player-form">
                        <img src="images/ion_arrow-undo-sharp.png" alt="">
                    </button>

                    <h5 class="modal-title">Add a new player</h5>
                </div>            
                    <!-- Form to add a new card -->
                    <form action="./php_controllers/playerController.php" method="POST" enctype="multipart/form-data" id="create-player-form">
                        <div class="form-floating">
                            <div id="form-floating-1">
                                <input type="text" name="playerName" id="playerNameInput" placeholder="Player Name">
                                <br>

                                <select name="teamID" id="teamSelect" class="form-control">
                                    <option value="">Select a Team</option>
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?= $team["teamID"]; ?>"><?= $team["teamName"]; ?></option>
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

                                <button type="submit" name="insert" id="create-player-button">Create Player</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script>
        function showButtons(card) {
            card.querySelector('.buttons-container').style.opacity = '1';
            card.querySelector('.buttons-container').style.transition = 'opacity 0.5s';
        }

        function hideButtons(card) {
            card.querySelector('.buttons-container').style.opacity = '0';
            card.querySelector('.buttons-container').style.transition = 'opacity 0.5s';
        }
    </script>
</body>


</html>
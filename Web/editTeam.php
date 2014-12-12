<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>IntraSMUrals</title>

    <!-- JavaScript Files -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/editTeam.js"></script>
    <script src="js/parser.js"></script>
    <script src="js/userCheck.js"></script>
    <script src="js/adminCheck.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/adminModal.js"></script>
    <script src="js/nav.js"></script>


    <!-- CSS Files -->
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/modal.css" rel="stylesheet" type="text/css">
    <link href="css/adminModals.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
</head>

<body>
<?php include "components/navbar.html"; include "components/modals.html"; include "components/adminModals.html"; ?>
<div class="center">
    <div class="section">
        <h2 class="pageHeader">Team Editor</h2>
        <h2 class="subHeader"></h2>

        <div id="teamSchedule">
            <h2 class="sectionHeader">Upcoming Games</h2>
            <div class="sportScheduleEvent">
                <div id="addNewGame">Add New Game</div>
            </div>
        </div>
        <div id="teamPlayerList">
            <h2 class="sectionHeader">Players</h2>

            <div id="addNewPlayers">
                <h2 class="teamTitle">Add New Players</h2>
            </div>


        </div>
    </div>
</div>
</body>
</html>
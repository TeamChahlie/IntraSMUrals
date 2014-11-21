<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>IntraSMUrals</title>

    <!-- JavaScript Files -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/adminCheck.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/adminPortal.js"></script>

    <!-- CSS Files -->
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/modal.css" rel="stylesheet" type="text/css">
    <link href="css/adminForms.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
</head>

<body>
<?php include "components/navbar.html"; include "components/modals.html"?>

    <div class="section">
        <h2 class="pageHeader">Admin Portal</h2>
        <div id="formView">
            <?php include "components/adminForms.html"; ?>
        </div>
        <div id="adminButtons">
            <div id="addSport" class="adminButton">Add Sport</div>
            <div id="deleteSport" class="adminButton">Delete Sport</div>
            <div id="addTeam" class="adminButton">Add Team</div>
            <div id="deleteTeam" class="adminButton">Delete Team</div>
            <div id="addGame" class="adminButton">Add Game</div>
            <div id="addResults" class="adminButton">Add Game Results</div>
            <div id="assignCaptain" class="adminButton">Assign Team Captain</div>
        </div>
    </div>
</body>
</html>
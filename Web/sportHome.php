<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>IntraSMUrals</title>

    <!-- JavaScript Files -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/parser.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/sportHome.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/modal.js"></script>

    <!-- CSS Files -->
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/modal.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
</head>

<body>
<?php include "components/navbar.html"; include "components/modals.html"?>

<div class="center">
    <div class="section">

        <h2 class="pageHeader"></h2>
            <div id="sportSchedule">
                <h2 class="sectionHeader">Upcoming and Recent Games</h2>
                <p class="noContent"></p>

    <!--            <div class="scheduleEvent">-->
    <!--                <span class="eventDate">Wednesday, Oct. 24th</span>-->
    <!--                <span class="eventTime">8:00 pm</span>-->
    <!--                <span class="vs">vs:</span>-->
    <!--                <span class="eventOpponent">Pastafarians</span>-->
    <!--                <span class="eventLocation">Intramural Fields</span>-->
    <!--            </div>-->

            </div>
            <div id="sportTeamList">
                <h2 class="sectionHeader">Teams</h2>
                <p id="noTeams" class="hidden">There are no teams in this sport yet. Check back later!</p>
            </div>

    </div>
</div>


</body>
</html>
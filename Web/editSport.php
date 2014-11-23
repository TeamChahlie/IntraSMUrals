<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>IntraSMUrals</title>

    <!-- JavaScript Files -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/userCheck.js"></script>
    <script src="js/adminCheck.js"></script>
    <script src="js/editSport.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/nav.js"></script>


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
        <h2 class="pageHeader">Sport Editor</h2>
        <h2 class="subHeader"></h2>
        <div id="sportTeamList">
            <h2 class="sectionHeader">Teams</h2>
            <p id="noTeams" class="hidden">There are no teams affiliated with this sport yet</p>
        </div>
        <div id="sportSchedule">
            <h2 class="sectionHeader">Upcoming Games</h2>
            <p class="noContent">Select a Team on the right to view upcoming games</p>

            <!--            <div class="scheduleEvent">-->
            <!--                <span class="eventDate">Wednesday, Oct. 24th</span>-->
            <!--                <span class="eventTime">8:00 pm</span>-->
            <!--                <span class="vs">vs:</span>-->
            <!--                <span class="eventOpponent">Pastafarians</span>-->
            <!--                <span class="eventLocation">Intramural Fields</span>-->
            <!--            </div>-->

        </div>

    </div>
</div>
</body>
</html>
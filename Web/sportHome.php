<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>IntraSMUrals</title>

    <!-- JavaScript Files -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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


<div class="section">
    
    <h2 class="pageHeader">My Sports</h2>
        <div id="studentSchedule">
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
        <div id="studentTeamList">
            <h2 class="sectionHeader">Teams</h2>
            <p id="noTeams" class="hidden">You are not currently signed up for a team! Go sign up for one now! (COMING SOON)</p>
        </div>

</div>


</body>
</html>
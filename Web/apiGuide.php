<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
    <meta content="" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>IntraSMUrals</title>

    <!-- JavaScript Files -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/home.js"></script>

    <!-- CSS Files -->
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/modal.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
</head>
<body>
    <?php include "components/navbar.html"; include "components/modals.html"?>

<div class="center">
        <div class="section" align="left">
        <div style="background-color:#FFFFFF; height:auto;  border-radius:9px; margin-top:10px; margin-bottom:10px; margin-left:60px; width:95%; padding:5px;">
        <center><h2>Web API Guide</h2></center>
        
        <center>All API calls are accessed via /api/index.php. This is an overview of all functions with the MySQL used to access the database and parameters necessary to use these functions. <p>
        <table border="2" width=80%  align="center">
        <tr>
        	<td><b>Variable Name</b></td>
            <td><b>Type</b></td>
        	<td><b>Description</b></td>
        </tr>
         <tr>
        	<td>studentID</td>
            <td>Int</td>
        	<td>Each student has a unique student ID designated by the university. This is used to track students and is stored in the database though not used publically. </td>
        </tr>
        <tr>
        	<td>teamName</td>
            <td>String</td>
        	<td>Each team has a unique name, this is stored in the "Team" table and used for display purposes.</td>
            <tr>
        	<td>sportName</td>
            <td>String</td>
        	<td>The name of each sport, this is stored in the "Sports" table along with the sportID(int). Used for display purposes. </td>
        </tr>
        <tr>
        	<td>teamID</td>
            <td>Int </td>
            <td>Each team has a unique ID which is used to connect students to the team in the Involvement table</td>
        </tr>
        </tr>
        </table>
        </centeR><p><p>
        <center><b>JSON Example</b><br>
        All calls use JSON with either http POST or http GET functionality. </center>
        <div align="center"><img src="img/jsonExample.png" width=25%></div>
        
        <b><h3>Pulling from Database</h3></b><p>
       
       
       
        <b><u>/adminStudentSearch</u></b><br>
         Returns the first and last name of a student based on the student ID.<br>
        <i>Required parameter:</i> student ID<br>
		<b>MySQL:</b> SELECT fname, lname FROM Student WHERE studentID = :id<p>
       


		<b><u>/adminStudentEmailList</b></u><br>
        Returns the first name, last name, and emails for all registered students.<br>
		<b>MySQL: </b>SELECT fname, lname, email FROM Student NATURAL JOIN User<p>
      

		<b><u>/adminSportSearch</b></u><br>
        Returns the names of all of the sports from the database.<br>
 		<b>MySQL:</b> SELECT sportName FROM sport<p>



<b><u>/getAllSports</u></b><br>
Returns the names of all the sports. <br>
<b>MySQL:</b> SELECT sportName FROM Sport ORDER BY sportName<p>


<b><u>/getStudentTeams</b></u><br>
Returns the team ID and team name for all teams. <br>
<b>MySQL:</b> SELECT teamID, teamName FROM Team NATURAL JOIN Involvement NATURAL JOIN Student WHERE studentID = :studentName<p>


<b><u>/getTeamInfo</b></u><br>
Returns the sport type for a specified team.<br>
<i>Required parameter</i>: team name<br>
<b>MySQL:</b> SELECT t.teamName, s.sportName FROM Team t, Sport s WHERE t.sportID = s.sportID AND t.teamName = :teamName<p>

<b><u>/getTeamCaptain</b></u><br>
Returns the name and email of the team captain.<br>
<i>Required parameter</i>: team name<br>
<b>MySQL:<br></b>SELECT fname, lname, email FROM Team INNER JOIN Student<br>
ON Team.captainID=Student.studentID WHERE teamName = :teamName<p>

<b><u>/getTeamSchedule</u></b><br>
Returns the match ID and team names.<br>
<i>Required Parameter</i>: team name<br>
<b>MySQL:</b> <br>SELECT matchID, teamName as opponent, ATeamScore as scoreFavor, BTeamScore as scoreAgainst, dateOF as date, timeOF as time FROM TeamMatch INNER JOIN Team ON TeamMatch.BteamID = Team.teamID WHERE AteamID = (SELECT teamID FROM Team WHERE teamName = :teamName)<p>
SELECT matchID, teamName as opponent, BTeamScore as scoreFavor, ATeamScore as scoreAgainst, dateOF as date, timeOF as time FROM TeamMatch INNER JOIN Team ON TeamMatch.AteamID = Team.teamID WHERE BteamID = (SELECT teamID FROM Team WHERE teamName = :teamName);<p>



<u><b>/getTeamRoster</u></b><br>
Returns the first and last name of each member of the specified team.<br>
<i>Required Parameter: </i>team name<br>
<b>MySQL:</b> SELECT fname, lname FROM Team NATURAL JOIN Involvement NATURAL JOIN Student WHERE teamName = :teamName ORDER BY lname<p>

<u><b>/getCaptainEmail</b></u><br>
Returns the teamname and email for the team captain.<br>
<i>Required Parameter: </i>team name<br>
<b>MySQL:</b> SELECT t.teamName, s.email FROM Team t INNER JOIN Student s ON t.captainID = s.studentID WHERE t.teamName = :teamName<p>

<u><b>/getStudentEmails</b></u><br>
Returns all emails from the student list.<br>
<b>MySQL:</b> SELECT email FROM student<p>

<u><b>/getTeamEmails</b></u><br>
Returns the email for all students from the specified team<.br>
<i>Required Parameters:</i>team name<br>
<b>MySQL</b>: SELECT email FROM student NATURAL JOIN Involvement NATURAL JOIN Team WHERE teamName = :teamName<p>

<u><b>/getMatches</b></u><br>
Returns all matches for all sports.<br>
<b>MySQL:</b> SELECT matchID FROM Teammatch NATURAL JOIN Sport ORDER BY sportName<p>

<u><b>/getUpcomingMatches</b></u><br>
Returns the upcoming matches. <br>
<b>MySQL:</b> SELECT matchID FROM Teammatch NATURAL JOIN Sport WHERE dateOf <= '$upcoming' AND dateOf > '$today' ORDER BY sportName<p>

<u><b>/getSportList</b></u><br>
Returns the sport name and number of teams for each sport.<br>
<b>MySQL</b>: SELECT sportName, COUNT(teamID) as teamCount FROM Sport LEFT JOIN Team
ON Sport.sportID=Team.sportID GROUP BY sportName<p>

<u><b>/getTeamsInSport/</b></u><br>
Returns the team name and team ID for a given sport<br>
<i>Required Parameter</i>: sport name<br>
<b>MySQL:</b> SELECT teamName, teamID FROM Sport NATURAL JOIN Team WHERE sportName = :sportName<p>

<u><b>/getMatchesInSport/</b></u><br>
<i>Required Parameter</i>: sport name<br>
<b>MySQL:</b> SELECT matchID, teamA, teamName AS teamB, ATeamScore AS teamAScore, BTeamScore AS teamBScore, dateOf, timeOf
            FROM (
                SELECT matchID, sportID, BteamID, ATeamScore, BTeamScore, dateOf, timeOf, teamName as teamA 
                FROM TeamMatch 
                INNER JOIN (
                        SELECT teamID, teamName 
                        FROM Team) AS table1 
                ON TeamMatch.AteamID = table1.teamID) AS table2 
            INNER JOIN (
                SELECT teamID, teamName
                FROM Team) AS table3 
            ON table2.BteamID = table3.teamID
            WHERE sportID = (
                SELECT sportID
                FROM Sport 
                WHERE sportName= :sportName)
            ORDER BY dateOf ASC<p>

        <u><b>/getStudentsInTeam/</b></u><br>
        Returns all of the students based on team ID<br>
        <i>Required Parameter:</i> Team ID<br>
        <b>MySQL:</b>SELECT fname, lname FROM Involvement NATURAL JOIN Student WHERE teamID = :teamID ORDER BY lname;<p> 
        
        <h3>Editing the Database</h3>
        
        <u><b>/Register</b></u><br>
        Functionality that occurs when a student tries to register. Checks if the student exists, if the student does not exist it creates a new student. If the student does exist but is not assigned an email, it updates the database with a selected email. <br>
<b>MySQL:</b> SELECT * FROM Student WHERE email = :email OR studentID = :studentID<br><br>
If the user doesn’t exist:<br>
<b>MySQL:</b> <br>INSERT INTO Student (`studentID`, `fname`, `lname`, `email`) VALUES (:studentID, :firstName, :lastName, :email)<br>
INSERT INTO User (`studentID`, `password`, `isAdmin`) VALUES (:studentID, :password, 0)<br><br>

If the user does exist:<br>
<b>MySQL:<br></b> UPDATE Student SET  studentID = :studentID, firstName = :firstName, lastName = :lastName WHERE email =$userInfo->Email]<br>
INSERT INTO User (`studentID`, `password`, `isAdmin`) VALUES (:studentID, :password, 0)<br><br>

If the student exists but an email hasn’t been added:<br>
<b>MySQL:</b><br> UPDATE Student SET  email =:Email, firstName = :firstName, lastName = :lastName WHERE studentID =" . $userInfo->StudentID<br>
UPDATE User SET password=:password, isAdmin= 0 WHERE studentID=" . $userInfo->StudentID<p>


<u><b>/insertCaptain</b></u><br>
Creates a captain for a team<br>
<b>MySQL: </b><br>
INSERT INTO Student VALUES (StudentID) (:studentID)<br>
INSERT INTO User VALUES (StudentID) (:studentID)<br>
INSERT INTO Team VALUES (CaptainID) (:captainID)<p>

<u><b>/insertSport</b></u><br>
Inserts a sport into the database<br>
<b>MySQL:</b> INSERT INTO Sport (sportName) Values (:sportName)<p>

<u><b>/deleteSport</b></u><br>
Deletes a sport from the database.<br>
<b>MySQL: </b>DELETE FROM Sport WHERE sportName = :sportName<p>


<u><b>/insertTeam</b></u><br>
Creates a new team to be inserted into the database<br>
<b>MySQL: </b>INSERT INTO Team (sportID, teamName) VALUES ((SELECT sportID FROM Sport WHERE sportName=:sportName), :teamName)<p>
<u><b>/deleteTeam</b></u><br>
Deletes a team from the database<br>
<b>MySQL: </b>DELETE FROM Team WHERE teamName = :teamName AND sportID = (SELECT sportID FROM Sport WHERE sportName= :sportName)<p>
<u><b>/insertMatch</b></u><br>
Inserts a match between two teams<br>
<b>MySQL: </b>INSERT INTO TeamMatch (sportID, AteamID, BteamID, dateOf, timeOf) 
            VALUES( (SELECT sportID FROM Sport WHERE sportName=:sportName), 
                    (SELECT teamID FROM Team WHERE teamName = :teamA AND sportID = 
                    (SELECT sportID FROM Sport WHERE sportName=:sportName)), 
                    (SELECT teamID FROM Team WHERE teamName = :teamB AND sportID = 
                    (SELECT sportID FROM Sport WHERE sportName=:sportName)), :dateOf, :timeOf)<p>
<u><b>/deleteMatch</b></u><br>
Deletes a match from the database<br>
<b>MySQL: </b>DELETE FROM TeamMatch WHERE matchID = :matchID<p>
<u><b>/updateMatchScore</b></u><br>
Updates scores for a match<br>
<b>MySQL: </b>UPDATE TeamMatch SET ATeamScore = :teamAScore, BTeamScore = :teamBScore WHERE matchID = :matchID<p>

        
        </div>
        
        
        </div>
        </div>


</body>
</html>

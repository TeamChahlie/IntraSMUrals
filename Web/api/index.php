<?php
require '../Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
# Define GET and POST requests here
$app->post('/login', 'login');
$app->post('/register', 'register');
$app->get('/adminCheck/:userID', 'adminCheck');

$app->post('/insertCaptain', 'insertCaptain');

$app->get('/adminStudentSearch', 'adminStudentSearch');
$app->get('/adminStudentEmailList', 'adminStudentEmailList');
$app->get('/adminSportSearch', 'adminSportSearch');
//$app->get('/getStudentInfo', 'getStudentInformation');
$app->get('/getAllSports', 'getAllSports');
$app->get('/getStudentTeams/:studentName', 'getStudentTeams');
$app->get('/getTeamInfo/:teamName', 'getTeamInfo');
$app->get('/getTeamCaptain/:teamName', 'getTeamCaptain');
$app->get('/getTeamSchedule/:teamName', 'getTeamSchedule');
$app->get('/getTeamRoster/:teamName', 'getTeamRoster');
$app->get('/getCaptainEmail/:teamName', 'getCaptainEmail');
$app->get('/getStudentEmails', 'getStudentEmails');
$app->get('/getTeamEmails/:teamName', 'getTeamEmails');
//$app->get('/getAdminEmails', 'getAdminEmails');
//$app->get('/getCaptainEmailsBySport/:sportName', 'getCaptainEmailsBySport');
$app->get('/getMatches', 'getMatches');
$app->get('/getUpcomingMatches', 'getUpcomingMatches');

//-----ADMIN Calls, please don't move anything between here and the next comment

//IntraSMUrals level
$app->get('/getSportList', 'getSportList');
$app->post('/insertSport', 'insertSport');
$app->post('/deleteSport', 'deleteSport');

//Sport level
$app->get('/getTeamsInSport/:sportName', 'getTeamsInSport');
$app->get('/getMatchesInSport/:sportName', 'getMatchesInSport');
$app->post('/insertTeam', 'insertTeam');
$app->post('/deleteTeam', 'deleteTeam');
$app->post('/insertMatch', 'insertMatch');
$app->post('/deleteMatch', 'deleteMatch');
$app->post('/updateMatchScore', 'updateMatchScore');



//Team level


//-----ADMIN Calls, please don't move anything between here and the previous comment

$app->run();

//============================== ADMIN ==============================//
// returns list of sports and number of teams in each
function getSportList() {
    $sql = "SELECT sportName, COUNT(teamID) as teamCount FROM Sport LEFT JOIN Team
ON Sport.sportID=Team.sportID GROUP BY sportName";
    try {
        $db = getConnection();
        $response = array();
        //first get home games
        $stmt = $db->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($response,$row);
        }
        
        $db = null;
        echo json_encode($response);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// inserts sport into database
function insertSport() {
    $sqlSport = "INSERT INTO SPORT (sportName) Values (:sportName)";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $sportInfo = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sqlSport);
        $stmt->bindParam("sportName", $sportInfo->sportName);
        $stmt->execute();
        echo '{"success": true}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// delete sport from database, will cascade to other tables
function deleteSport() {
    $sqlSport = "DELETE FROM Sport WHERE sportName = :sportName";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $sportInfo = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sqlSport);
        $stmt->bindParam("sportName", $sportInfo->sportName);
        $stmt->execute();
        echo '{"success": true}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// returns teams in a specific sport
function getTeamsInSport($sportName) {
    $sql = "SELECT teamName FROM Sport NATURAL JOIN Team WHERE sportName = :sportName";
    try {
        $db = getConnection();
        $response = array();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sportName", $sportName);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($response,$row);
        }
        $db = null;
        echo json_encode($response);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// returns matches in a specific sport
function getMatchesInSport($sportName) {
    $sql = "SELECT matchID, teamA, teamName AS teamB, ATeamScore AS teamAScore, BTeamScore AS teamBScore, dateOf, timeOf
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
            ORDER BY dateOf ASC";
    try {
        $db = getConnection();
        $response = array();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sportName", $sportName);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($response,$row);
        }
        $db = null;
        echo json_encode($response);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//Should insert team info
function insertTeam() {
    $sqlTeam = "INSERT INTO Team (sportID, teamName) VALUES ((SELECT sportID FROM Sport WHERE sportName=:sportName), :teamName)";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $teamInfo = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sqlTeam);
        $stmt->bindParam("sportName", $teamInfo->sportName);
        $stmt->bindParam("teamName", $teamInfo->teamName);
        $stmt->execute();
        echo '{"success": true}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// delete team from database, will cascade to other tables
function deleteTeam() {
    $sql = "DELETE FROM Team WHERE teamName = :teamName AND sportID = (SELECT sportID FROM Sport WHERE sportName= :sportName)";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $info = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sportName", $info->sportName);
        $stmt->bindParam("teamName", $info->teamName);
        $stmt->execute();
        echo '{"success": true}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// insert Match to database
function insertMatch() {
    $sql = "INSERT INTO TeamMatch (sportID, AteamID, BteamID, dateOf, timeOf) 
            VALUES( (SELECT sportID FROM Sport WHERE sportName=:sportName), 
                    (SELECT teamID FROM Team WHERE teamName = :teamA AND sportID = 
                    (SELECT sportID FROM Sport WHERE sportName=:sportName)), 
                    (SELECT teamID FROM Team WHERE teamName = :teamB AND sportID = 
                    (SELECT sportID FROM Sport WHERE sportName=:sportName)), :dateOf, :timeOf)";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $info = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sportName", $info->sportName);
        $stmt->bindParam("teamA", $info->teamA);
        $stmt->bindParam("teamB", $info->teamB);
        $stmt->bindParam("dateOf", $info->dateOf);
        $stmt->bindParam("timeOf", $info->timeOf);
        $stmt->execute();
        echo '{"success": true}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// delete match from database, will cascade to other tables
function deleteMatch() {
    $sql = "DELETE FROM TeamMatch WHERE matchID = :matchID";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $info = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("matchID", $info->matchID);
        $stmt->execute();
        echo '{"success": true}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// update score on a match
function updateMatchScore() {
    $sql = "UPDATE TeamMatch SET ATeamScore = :teamAScore, BTeamScore = :teamBScore WHERE matchID = :matchID";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $info = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("matchID", $info->matchID);
        $stmt->bindParam("teamAScore", $info->teamAScore);
        $stmt->bindParam("teamBScore", $info->teamBScore);
        $stmt->execute();
        echo '{"success": true}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//Inserting a student into the database (no involvement added at this time)
function insertCaptain() {
    $sqlStudent = "INSERT INTO Student VALUES (StudentID) (:studentID)";
    $sqlUser = "INSERT INTO User VALUES (StudentID) (:studentID)";
    $sqlCaptain = "INSERT INTO Team VALUES (CaptainID) (:captainID)";

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $studentInfo = json_decode($request->getBody());
    try {
        if (isset($sqlStudent)) {
            $db = getConnection();
            //Adds to student table
            $stmt = $db->prepare($sqlStudent);
            $stmt->bindParam("StudentID", $studentInfo->studentId);
            $stmt->execute();
        }
        if (isset($sqlUser)) {
            //Adds to user table
            $stmt = $db->prepare($sqlUser);
            $stmt->bindParam("StudentID", $studentInfo->studentId);
            $stmt->execute();
        }
        if (isset($sqlCaptain)) {
            //Adds user to team table
            $stmt = $db->prepare($sqlCaptain);
            $stmt->bindParam("CaptainID", $studentInfo->captainId);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//============================== GENERAL FUNCTIONS ==============================//
// checks if email and password match a user and returns his info
function login() {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $loginInfo = json_decode($request->getBody());
    $sql = "SELECT u.studentID, u.isAdmin, s.fname, s.lname, s.email FROM User u NATURAL JOIN Student s WHERE email = :email AND password = :password";
    try {
        if (isset($loginInfo)) {
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("email", $loginInfo->email);
            $stmt->bindParam("password", $loginInfo->password);
            $stmt->execute();
            $userInfo = $stmt->fetch(PDO::FETCH_OBJ);
            $db = null;
            $response['info'] = $userInfo;
            echo json_encode($response);
        }
        else {
            echo '{"error":{"text": "Bad things happened! JSON was not valid" }}';
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//Registration for new user
function register() {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $userInfo = json_decode($request->getBody());
    $userExists = FALSE;
    $isStudentID = FALSE;
    $isEmail = FALSE;
    $userTest = "SELECT * FROM Student WHERE email = :email OR studentID = :studentID";
    try {
        $db = getConnection();
        $stmt = $db->prepare($userTest);
        $stmt->bindParam('email', $userInfo->Email);
        $stmt->bindParam('studentID', $userInfo->StudentID);
        $stmt->execute();
        $accountCheck = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($accountCheck)) {
            $userExists = FALSE;
        } else {
            $userExists = TRUE;
            if ($accountCheck['email'] == $userInfo->Email) {
                $isEmail = TRUE;
            } else {
                $isEmail = FALSE;
            }
            if ($accountCheck['studentID'] == $userInfo->StudentID) {
                $isStudentID = TRUE;
            } else {
                $isStudentID = FALSE;
            }
        }
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
    //In the case of an entirely new user
    if ($userExists == FALSE) {
        $studentSQL = "INSERT INTO Student (`studentID`, `fname`, `lname`, `email`) VALUES (:studentID, :firstName, :lastName, :email)";
        $userSQL = "INSERT INTO User (`studentID`, `password`, `isAdmin`) VALUES (:studentID, :password, 0)";
        try {
            if (isset($userInfo)) {
                $db = getConnection();
                $stmt = $db->prepare($studentSQL);
                $stmt->bindParam("studentID", $userInfo->StudentID);
                $stmt->bindParam("firstName", $userInfo->FirstName);
                $stmt->bindParam("lastName", $userInfo->LastName);
                $stmt->bindParam("email", $userInfo->Email);
                $success1 = $stmt->execute();
                $db = getConnection();
                $stmt = $db->prepare($userSQL);
                $stmt->bindParam("studentID", $userInfo->StudentID);
                $stmt->bindParam("password", $userInfo->Password);
                $success2 = $stmt->execute();
                if ($success1 && $success2) {
                    echo '{"info": true}';
                } else {
                    echo '{"info": false}';
                }
                $db = null;
            } else {
                echo '{"error":{"text": "Bad things happened! JSON was not valid" }}';
            }
        } catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    } else {
        //If the user does exist in some capacity
        if ($isEmail == TRUE && $isStudentID == TRUE) {
            echo '{"error":{"text": "An account with this email and ID already exists!"}}';
        } else if ($isEmail == TRUE && $isStudentID == FALSE) {
            $studentSQL = "UPDATE Student SET  studentID = :studentID, firstName = :firstName, lastName = :lastName WHERE email =$userInfo->Email]";
            $userSQL = "INSERT INTO User (`studentID`, `password`, `isAdmin`) VALUES (:studentID, :password, 0)";
            try {
                if (isset($userInfo)) {
                    $db = getConnection();
                    $stmt = $db->prepare($studentSQL);
                    $stmt->bindParam("studentID", $userInfo->StudentID);
                    $stmt->bindParam("firstName", $userInfo->FirstName);
                    $stmt->bindParam("lastName", $userInfo->LastName);
                    $stmt->bindParam("email", $userInfo->Email);
                    $success1 = $stmt->execute();
                    $db = getConnection();
                    $stmt = $db->prepare($userSQL);
                    $stmt->bindParam("studentID", $userInfo->StudentID);
                    $stmt->bindParam("password", $userInfo->Password);
                    $success2 = $stmt->execute();
                    if ($success1 && $success2) {
                        echo '{"info": true}';
                    } else {
                        echo '{"info": false}';
                    }
                    $db = null;
                } else {
                    echo '{"error":{"text": "Bad things happened! JSON was not valid" }}';
                }
            } catch (PDOException $e) {
                echo '{"error":{"text":' . $e->getMessage() . '}}';
            }
        } else if ($isStudentID == TRUE && $isEmail == FALSE) {
            $studentSQL = "UPDATE Student SET  email =:Email, firstName = :firstName, lastNmae = :lastName WHERE studentID =" . $userInfo->StudentID;
            $userSQL = "UPDATE User SET password=:password, isAdmin= 0 WHERE studentID=" . $userInfo->StudentID;
            try {
                if (isset($userInfo)) {
                    $db = getConnection();
                    $stmt = $db->prepare($studentSQL);
                    $stmt->bindParam("studentID", $userInfo->StudentID);
                    $stmt->bindParam("firstName", $userInfo->FirstName);
                    $stmt->bindParam("lastName", $userInfo->LastName);
                    $stmt->bindParam("email", $userInfo->Email);
                    $success1 = $stmt->execute();
                    $db = getConnection();
                    $stmt = $db->prepare($userSQL);
                    $stmt->bindParam("studentID", $userInfo->StudentID);
                    $stmt->bindParam("password", $userInfo->Password);
                    $success2 = $stmt->execute();
                    if ($success1 && $success2) {
                        echo '{"info": true}';
                    } else {
                        echo '{"info": false}';
                    }
                    $db = null;
                } else {
                    echo '{"error":{"text": "Bad things happened! JSON was not valid" }}';
                }
            } catch (PDOException $e) {
                echo '{"error":{"text":' . $e->getMessage() . '}}';
            }
        }
    }
}

// returns if user is admin
function adminCheck($userID) {
    $sql = "SELECT isAdmin FROM User WHERE studentID = :userID";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('userID', $userID);
        $stmt->execute();
        $adminVal = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($adminVal['isAdmin'] == 0) {
            echo '{"isAdmin": false}';
        } else if ($adminVal['isAdmin'] == 1) {
            echo '{"isAdmin": true}';
        } else{
            echo '{"error:{"text": "Unknown error occurred."}}';
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//============================== ADMIN SEARCH FUNCTIONS ==============================//
//This returns ONLY THE NAME based on ID
function adminStudentSearch() {
    $sqlStudent = "SELECT fname, lname FROM Student WHERE studentID = :id";
    try {
        $db = getConnection();
        $stmt = $db->query($sqlStudent);
        $Student = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Student = array(
                'FirstName' => $row['fname'],
                'LastName' => $row['lname'],
            );
            echo json_encode($Student);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
//Returns entire list of students with first and last name, and email
function adminStudentEmailList() {
    $sqlStudent = "SELECT fname, lname, email FROM Student NATURAL JOIN User";
    try {
        $db = getConnection();
        $stmt = $db->query($sqlStudent);
        $Student = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Student = array(
                'FirstName' => $row['fname'],
                'LastName' => $row['lname'],
                'Email' => $row['email'],
            );
            echo json_encode($Student);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
// 
function adminSportSearch() {
    $sqlSport = "SELECT sportName FROM sport";
    try {
        $db = getConnection();
        $stmt = $db->query($sqlSport);
        $Sport = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Sport = array(
                'Sport' => $row['sportName'],
            );
            echo json_encode($Sport);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//============================== GENERAL VIEW FUNCTIONS ==============================//
// returns a team's scheduled games with scores and opponents
function getTeamRoster($teamName) {
    $sql = "SELECT fname, lname FROM Team NATURAL JOIN Involvement NATURAL JOIN Student WHERE teamName = :teamName ORDER BY lname";
    try {
        $db = getConnection();
        $response = array();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("teamName", $teamName);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($response,$row);
        }
        $db = null;
        echo json_encode($response);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
// returns a team's scheduled games with scores and opponents
function getStudentTeams($studentName) {
    $sql = "SELECT teamID, teamName FROM Team NATURAL JOIN Involvement NATURAL JOIN Student WHERE studentID = :studentName";
    try {
        $db = getConnection();
        $response = array();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("studentName", $studentName);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($response,$row);
        }
        $db = null;
        echo json_encode($response);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
// returns a team's scheduled games with scores and opponents
function getTeamSchedule($teamName) {
    $sqlHomeGames = "SELECT matchID, teamName as opponent, ATeamScore as scoreFavor, BTeamScore as scoreAgainst,
                            dateOF as date, timeOF as time
                      FROM TeamMatch INNER JOIN Team ON TeamMatch.BteamID = Team.teamID
                      WHERE AteamID = (SELECT teamID FROM Team WHERE teamName = :teamName)";
    $sqlAwayGames = "SELECT matchID, teamName as opponent, BTeamScore as scoreFavor, ATeamScore as scoreAgainst,
                            dateOF as date, timeOF as time
                      FROM TeamMatch INNER JOIN Team ON TeamMatch.AteamID = Team.teamID
                      WHERE BteamID = (SELECT teamID FROM Team WHERE teamName = :teamName);";
    try {
        $db = getConnection();
        $response = array();
        //first get home games
        $stmt = $db->prepare($sqlHomeGames);
        $stmt->bindParam("teamName", $teamName);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($response,$row);
        }
        //then get away games
        $stmt = $db->prepare($sqlAwayGames);
        $stmt->bindParam("teamName", $teamName);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($response,$row);
        }
        $db = null;
        echo json_encode($response);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
// returns team Information as JSON
function getTeamInfo($teamName) {
    $sql = "SELECT t.teamName, s.sportName FROM Team t, Sport s WHERE t.sportID = s.sportID AND t.teamName = :teamName";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        // bind Parameters to query
        $stmt->bindParam("teamName", $teamName);
        $stmt->execute();
        $response = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($response);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getAllSports() {
    $sql = "SELECT sportName FROM Sport ORDER BY sportName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $sports = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sports[] = $row['sportName'];
        }
        $db = null;
        echo json_encode($sports);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

// returns a team captain's firstname, lastname, and email as JSON
function getTeamCaptain($teamName) {
    $sql = "SELECT fname, lname, email FROM Team INNER JOIN Student
ON Team.captainID=Student.studentID WHERE teamName = :teamName";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        // bind Parameters to query
        $stmt->bindParam("teamName", $teamName);
        $stmt->execute();
        $response = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($response);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//View the captain emails for every team - returns team name and email. 
function getCaptainEmail ($teamName) {
//if you're getting it by team
     $sql = "SELECT t.teamName, s.email FROM Team t INNER JOIN Student s ON t.captainID = s.studentID WHERE t.teamName = :teamName";
//If you want it by team ID
     //$sql = "SELECT teamName, email FROM Team NATURAL JOIN student WHERE studentID = captainID AND teamID = :teamID";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('teamName', $teamName);
        $stmt->execute();
        $Teams = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Emails = array(
                'TeamName' => $row['teamName'],
                'emails' => $row['email'],
            );
            echo json_encode($Emails);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//returns ONLY student emails
function getStudentEmails() {
//if you're getting all of them
     $sql = "SELECT email FROM student";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $Emails = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Emails[] = $row['email'];
        }
        echo json_encode($Emails);

    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}


function getTeamEmails($teamName) {
//if you're getting it by team
     $sql = "SELECT email FROM student NATURAL JOIN Involvement NATURAL JOIN Team WHERE teamName = :teamName";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('teamName', $teamName);
        $stmt->execute();
        $Emails = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Emails[] = $row['email'];
        }
        echo json_encode($Emails);

    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

/*
function getAdminEmails() {
//all admin emails
     $sql = "SELECT email FROM student NATURAL JOIN user WHERE isAdmin != 0";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $Emails = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Emails[] = $row['email'];
        }
        echo json_encode($Emails);

    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getCaptainEmailsBySport ($sportName) {
     $sql = "SELECT t.teamName, s.email FROM Team t INNER JOIN Student s ON t.captainID = s.studentID JOIN Sport ON t.sportID = Sport.sportID WHERE Sport.sportName = :sportName";
//If you want it by sport ID
     //$sql = "SELECT t.teamName, s.email FROM Team t INNER JOIN Student s ON t.captainID = s.studentID JOIN Sport ON t.sportID = Sport.sportID WHERE Sport.sportID = :sportID";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('sportName',$sportName);
        $stmt->execute();
        $Teams = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Emails = array(
                'TeamName' => $row['teamName'],
                'emails' => $row['email'],
            );
            echo json_encode($Emails);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
*/

//returns the match information based on the SportName should be checked
//function getUniversalSportSchedule() {
//    $sqlSportProfile = "SELECT firstTeam.teamName, secondTeam.teamName, dateOf, timeOf FROM sport NATURAL JOIN Schedule NATURAL JOIN TeamMatch NATURAL JOIN Team INNER JOIN Team WHERE sportName = :sportName AND ATeamID = firstTeam.teamID AND BTeamID = secondTeam.teamID";
//    try {
//        $db = getConnection();
//        $stmt = $db->prepare($sqlSportProfile);
//        $stmt->bindParam('sportName', $sportInfo->sportName);
//        $stmt->execute();
//        $Sports = array();
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $Sports = array(
//                'MatchID' => $row['matchID'],
//                'ATeamID' => $row['AteamID'],
//                'BTeamID' => $row['BteamID'],
//                'MatchDate' => $row['dateOf'],
//                'MatchTime' => $row['timeOf'],
//            );
//            echo json_encode($Sports);
//        }
//    }
//    catch (PDOException $e) {
//        echo '{"error":{"text":' . $e->getMessage() . '}}';
//    }
//}

//Returns all information about a particular student
//function getStudentInformation() {
//    $sqlStudentProfile = "SELECT studentName, email, teamName FROM Student natural join involvement natural join team WHERE fname = $fname AND lname = $lname";
//    try {
//        $db = getConnection();
//        $stmt = $db->query($sqlStudentProfile);
//        $Student = array();
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $Student = array(
//                'FirstName' => $row['fname'],
//                'LastName' => $row['lname'],
//                'Email' => $row['email'],
//                'TeamName' => $row['teamName']
//                //If one student is on multiple teams there will be multiple rows
//            );
//            echo json_encode($Student);
//        }
//    } catch (PDOException $e) {
//        echo '{"error":{"text":' . $e->getMessage() . '}}';
//    }
//}


//Returns teamNames from a specific sport based on ID (can make based on name if preferable)
//function viewTeams() {
//    $sql = "SELECT teamName from Sport WHERE sportID = :sportID";
//    try {
//        $db = getConnection();
//        $stmt = $db->prepare($sql);
//        $sportInfo = json_decode($request->getBody());
//        $stmt->bindParam('sportID', $sportInfo->sportID);
//        $stmt->execute();
//        $Teams = array();
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            $Teams = array(
//                'TeamName' => $row['teamName'],
//            );
//            echo json_encode($Teams);
//        }
//    } catch (PDOException $e) {
//        echo '{"error":{"text":' . $e->getMessage() . '}}';
//    }
//}

//should return matches grouped by sport
function getMatches() {
    $sql = "SELECT matchID FROM Teammatch NATURAL JOIN Sport ORDER BY sportName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $matches = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $matches[] = $row['matchID'];
        }
        $db = null;
        echo json_encode($matches);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//should return matches for next two weeks grouped by sport
function getUpcomingMatches() {
    date_default_timezone_set('America/Chicago');
    $today = date_create();
    $upcoming = date_add($today, new DateInterval('P14D'));
    $today = $today->format('Y-m-d');
    $upcoming = $upcoming->format('Y-m-d');
    $sql = "SELECT matchID FROM Teammatch NATURAL JOIN Sport WHERE dateOf <= '$upcoming' AND dateOf > '$today' ORDER BY sportName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $matches = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $matches[] = $row['matchID'];
        }
        $db = null;
        echo json_encode($matches);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getConnection() {
    $dbhost = "127.0.0.1";
    $dbpass = "";
    // $dbhost = "localhost";
    // $dbpass = "root";
    $dbuser = "root";
    $dbname = "IntraSMUrals";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
?>
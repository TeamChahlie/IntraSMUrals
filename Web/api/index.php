<?php
require '../Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
# Define GET and POST requests here
$app->post('/login', 'login');
$app->post('/register', 'register');
$app->post('/insertSport', 'insertSport');
$app->post('/insertTeam', 'insertTeam');
$app->post('/insertStudent', 'insertStudent');
$app->get('/getStudentInfo', 'getStudentInformation');
$app->get('/adminStudentSearch', 'adminStudentSearch');
$app->get('/adminStudentEmailList', 'adminStudentEmailList');
$app->get('/adminSportSearch', 'adminSportSearch');
$app->get('/adminCheck/:userID', 'adminCheck');
$app->get('/addScores', 'addScores');
$app->get('/insertMatch', 'insertMatch');
$app->get('/getStudentTeams/:studentName', 'getStudentTeams');
$app->get('/getTeamInfo/:teamName', 'getTeamInfo');
$app->get('/getTeamCaptain/:teamName', 'getTeamCaptain');
$app->get('/getTeamSchedule/:teamName', 'getTeamSchedule');
$app->get('/getTeamRoster/:teamName', 'getTeamRoster');
$app->run();
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
//returns the match information based on the SportName should be checked
function getUniversalSportSchedule() {
    $sqlSportProfile = "SELECT firstTeam.teamName, secondTeam.teamName, dateOf, timeOf FROM sport NATURAL JOIN Schedule NATURAL JOIN TeamMatch NATURAL JOIN Team INNER JOIN Team WHERE sportName = :sportName AND ATeamID = firstTeam.teamID AND BTeamID = secondTeam.teamID";
    try {
        $db       = getConnection();
        $stmt     = $db->prepare($sql);
        $sportInfo = json_decode($request->getBody());
        $stmt->bindParam('sportName', $sportInfo->sportName);
        $stmt->execute();
        $Sports = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Sports = array(
                'MatchID' => $row['matchID'],
                'ATeamID' => $row['AteamID'],
                'BTeamID' => $row['BteamID'],
                'MatchDate' => $row['dateOf'],
                'MatchTime' => $row['timeOf'],
            );
            echo json_encode($Sports);
        }
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
//Registration for new user
function register() {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $userInfo = json_decode($request->getBody());
    $userExists = FALSE;
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
        }
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
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
        echo '{"error":{"text": "An account with that email address already exists!"}}';
    }
}
//Returns all information about a particular student
function getStudentInformation() {
    $sqlStudentProfile = "SELECT studentName, email, teamName FROM Student natural join involvement natural join team WHERE fname = $fname AND lname = $lname";
    try {
        $db = getConnection();
        $stmt = $db->query($sqlStudentProfile);
        $Student = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Student = array(
                'FirstName' => $row['fname'],
                'LastName' => $row['lname'],
                'Email' => $row['email'],
                'TeamName' => $row['teamName']
                //If one student is on multiple teams there will be multiple rows
            );
            echo json_encode($Student);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
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

function adminCheck($userID) {
    $sql = "SELECT isAdmin FROM User WHERE studentID = :userID";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('userID', $userID);
        $stmt->execute();
        $adminVal = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($adminVal['isAdmin'] == 0)
            echo '{"isAdmin": false}';
        else if ($adminVal['isAdmin'] == 1)
            echo '{"isAdmin": true}';
        else
            echo '{"error:{"text": "Unknown error occurred."}}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//Returns teamNames from a specific sport based on ID (can make based on name if preferable)
function viewTeams() {
    $sql = "SELECT teamName from Sport WHERE sportID = :sportID";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $sportInfo = json_decode($request->getBody());
        $stmt->bindParam('sportID', $sportInfo->sportID);
        $stmt->execute();
        $Teams = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Teams = array(
                'TeamName' => $row['teamName'],
            );
            echo json_encode($Teams);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
//Should insert sport and ID (if there's a convention besides just incrementing) 
function insertSport() {
    $sqlSport = "INSERT INTO SPORT Values (:sportID, :sportName)";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $sportInfo = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sqlSport);
        $stmt->bindParam("sportID", $sportInfo->id);
        $stmt->bindParam("sportName", $sportInfo->sportName);
        $stmt->execute();
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
//Should insert team info
function insertTeam() {
    $sqlTeam = "INSERT INTO Team Values (:sportID, :teamID, :teamName, :captainID);";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $teamInfo = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sqlTeam);
        $stmt->bindParam("sportID", $teamInfo->sportId);
        $stmt->bindParam("teamID", $teamInfo->teamID);
        $stmt->bindParam("teamName", $teamInfo->teamName);
        $stmt->bindParam("captainName", $teamInfo->captainID);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
//Inserting a student into the database (no involvement added at this time)
function insertStudent() {
    $sqlStudent = "INSERT INTO Student Values (:studentID, :fname, :lname, :email)";
    $sqlUser = "INSERT INTO User Values(:studentID, :password, :isAdmin)";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $studentInfo = json_decode($request->getBody());
    try {
        if (isset($sqlStudent)) {
            $db = getConnection();
            //Adds to student table
            $stmt = $db->prepare($sqlStudent);
            $stmt->bindParam("studentID", $studentInfo->studentid);
            $stmt->bindParam("fname", $studentInfo->fname);
            $stmt->bindParam("lname", $studentInfo->lname);
            $stmt->bindParam("email", $studentInfo->email);
            $stmt->execute();
        }
        if (isset($sqlUser)) {
            //Adds to user table
            $stmt = $db->prepare($sqlUser);
            $stmt->bindParam("studentID", $studentInfo->studentid);
            $stmt->bindParam("password", $studentInfo->assignedPassword);
            $stmt->bindParam("isAdmin", $studentInfo->isAdmin);
            $stmt->execute();
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
//Should insert team info (both match ids are autoincremented)
function insertMatch() {
    $sqlMatch = "INSERT INTO TeamMatch VALUES (ATeamID, BTeamID, dateOf, timeOf) (:aTeamID, :bTeamID, :timeof,  :dateof);";
    $sqlSchedule = "INSERT INTO Schedule VALUES (SportID) (:sportID)";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $matchInfo = json_decode($request->getBody());
    $scheduleInfo = json_decode($request->getBody());
    try {
        if( isset($sqlMatch)) {
            $db = getConnection();
            $stmt = $db->prepare($sqlMatch);
            $stmt->bindParam("ATeamID", $matchInfo->aTeamID);
            $stmt->bindParam("BTeamID", $matchInfo->bTeamID);
            $stmt->bindParam(":dateOf", $matchInfo->dateOf);
            $stmt->bindParam(":timeOf", $matchInfo->timeOf);
        }
        if(isset($sqlSchedule)) {
            $stmt = $db->prepare($sqlSchedule);
            $stmt->bindParam("SportID", $scheduleInfo->sportID);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
//Should update database with admin-inserted scores
function addScores() {
    $sqlScores = "UPDATE TeamMatch SET ATeamScore = :AScore, BTeamScore = :BScore WHERE matchID = :matchNumber";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $scoreInfo = json_decode($request->getBody());
    try {
        $db = getConnection();
        $stmt = $db->prepare($sqlScores);
        $stmt->bindParam("AScore", $scoreInfo->aScore);
        $stmt->bindParam("BScore", $scoreInfo->bScore);
        $stmt->bindParam("matchNumber", $scoreInfo->matchID);
        $stmt->execute();
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
function getConnection() {
    $dbhost = "127.0.0.1";
    $dbpass = "";
//    $dbhost = "localhost";
//    $dbpass = "root";
    $dbuser = "root";
    $dbname = "intrasmurals";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
?>
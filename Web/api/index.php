<?php

require '../Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

# Define GET and POST requests here
$app->post('/login', 'login');
$app->post('/registration', 'register');
$app->post('/insertSport', 'insertSport');
$app->post('/insertTeam', 'insertTeam');
$app->post('/insertStudent', 'insertStudent');
$app->get('/getStudentInfo', 'getStudentInformation');
$app->get('/adminStudentSearch', 'adminStudentSearch');
$app->get('/adminStudentEmailList', 'adminStudentEmailList');
$app->get('/adminSportSearch', 'adminSportSearch');
$app->run();

function login() {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $loginInfo = json_decode($request->getBody());
    $sql = "SELECT CustomerID, FirstName, LastName, CreditCardProvider, CreditCardNumber, LastOrder FROM Customer WHERE Email = :email AND Password = :password";
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
        } else
            echo '{"error":{"text": "Bad things happened! JSON was not valid" }}';
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

    $userTest = "SELECT StudentID FROM Student NATURAL JOIN User WHERE Student.Email = :email";

    try {
        $db = getConnection();
        $stmt = $db->prepare($userTest);
        $stmt->bindParam('email', $userInfo->Email);
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

        $studentSQL = "INSERT INTO Student (`StudentID`, `FirstName`, `LastName`, `Email`) VALUES (:firstName, :lastName, :email)";
        $userSQL = "INSERT INTO User (`StudentID`, `Password`, `isAdmin`) VALUES (:studentID, :password, :isAdmin)";

        try {
            if (isset($userInfo)) {
                $db = getConnection();
                $stmt = $db->prepare($studentSQL);
                $stmt->bindParam("studentID", $userInfo->StudentID);
                $stmt->bindParam("firstName", $userInfo->FirstName);
                $stmt->bindParam("lastName", $userInfo->LastName);
                $stmt->bindParam("email", $userInfo->Email);
                $success = $stmt->execute();
                $newUserID = $db->lastInsertId();
                if ($success) {
                    $newUserID = $db->lastInsertId();
                    echo '{"info": true, "userID": ' . $newUserID . '}';
                } else {
                    echo '{"info": false}';
                }
                $db = null;
            } else {
                echo '{"error":{"text": "Bad things happened! JSON was not valid" }}';
            }

            if (isset($userInfo)) {
                $db = getConnection();
                $stmt = $db->prepare($userSQL);
                $stmt->bindParam("studentID", $userInfo->StudentID);
                $stmt->bindParam("password", $userInfo->Password);
                $stmt->bindParam("isAdmin", $userInfo->isAdmin);
                $success = $stmt->execute();
                $newUserID = $db->lastInsertId();
                if ($success) {
                    $newUserID = $db->lastInsertId();
                    echo '{"info": true, "userID": ' . $newUserID . '}';
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

function populateCustomer() {
    $userID = "?????? Please Help";
    $sqlCustomer = "SELECT * From Customer WHERE CustomerID = $userID";
    try {
        $db = getConnection();
        $stmt = $db->query($sqlCustomer);
        $Customer = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Customer = array(
                'CustomerID' => $row['CustomerID'],
                'FirstName' => $row['FirstName'],
                'LastName' => $row['LastName'],
                'Email' => $row['Email'],
                'Password' => $row['Password'],
                'CreditCardProvider' => $row['CreditCardProvider'],
                'CreditCardNumber' => $row['CreditCardNumber']
            );
            echo json_encode($Customer);
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

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
        $db = getConnection();
        //Adds to student table
        $stmt = $db->prepare($sqlStudent);
        $stmt->bindParam("studentID", $studentInfo->studentid);
        $stmt->bindParam("fname", $studentInfo->fname);
        $stmt->bindParam("lname", $studentInfo->lname);
        $stmt->bindParam("email", $studentInfo->email);
        $stmt->execute();

        //Adds to user table
        $stmt = $db->prepare($sqlUser);
        $stmt->bindParam("studentID", $studentInfo->studentid);
        $stmt->bindParam("password", $studentInfo->assignedPassword);
        $stmt->bindParam("isAdmin", $studentInfo->isAdmin);
        $stmt->execute();
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//Should insert team info
function insertMatch() {
    $sqlMatch = "INSERT INTO TeamMatch VALUES (ATeamID, BTeamID, dateOf, timeOf) (:aTeamID, :bTeamID, :timeof,  :dateof);";
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $matchInfo = json_decode($request->getBody());

    try {
        $db = getConnection();
        $stmt = $db->prepare($sqlMatch);
        $stmt->bindParam("ATeamID", $matchInfo->aTeamID);
        $stmt->bindParam("BTeamID", $matchInfo->bTeamID);
        $stmt->bindParam(":dateOf", $matchInfo->dateOf);
        $stmt->bindParam(":timeOf", $matchInfo->timeOf);
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function addScores() {
    $sqlScores = "UPDATE TeamMatch SET ATeamScore = :AScore, BTeamScore = :BScore WHERE matchID = :matchNumber";

    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $scoreInfo = json_decode($request->getBody());

    try {
        $db = getConnection();
        //Adds to student table
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
    $dbuser = "root";
    $dbpass = "";
    $dbname = "intrasmurals";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>

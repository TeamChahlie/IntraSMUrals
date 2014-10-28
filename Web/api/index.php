<?php
require '../Slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

# Define GET and POST requests here
$app->post('/login', 'login');
$app->post('/registration', 'register');
//$app->post('/makingBurger', 'makeBurger');
//$app->post('/order', 'makeOrder');
$app->post('/getStudentInfo', 'getStudentInformation');
//$app->get('/customerInfo', 'populateCustomer');
//$app->get('/lastBurger', 'getLastBurger');
//$app->get('/lastOrder', 'getLastOrder');
//$app->get('/menu', 'getMenu');
$app->run();

function login() {
    $app       = \Slim\Slim::getInstance();
    $request   = $app->request();
    $loginInfo = json_decode($request->getBody());
    $sql       = "SELECT CustomerID, FirstName, LastName, CreditCardProvider, CreditCardNumber, LastOrder FROM Customer WHERE Email = :email AND Password = :password";
    try {
        if (isset($loginInfo)) {
            $db   = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("email", $loginInfo->email);
            $stmt->bindParam("password", $loginInfo->password);
            $stmt->execute();
            $userInfo         = $stmt->fetch(PDO::FETCH_OBJ);
            $db               = null;
            $response['info'] = $userInfo;
            echo json_encode($response);
        } else
            echo '{"error":{"text": "Bad things happened! JSON was not valid" }}';
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//Registration for new user
function register() {
    $app          = \Slim\Slim::getInstance();
    $request      = $app->request();
    $userInfo = json_decode($request->getBody());
    $userExists = FALSE;

    $userTest = "SELECT StudentID FROM Student NATURAL JOIN User WHERE Student.Email = :email";

    try {
        $db = getConnection();
        $stmt = $db->prepare($userTest);
        $stmt->bindParam('email', $userInfo->Email);
        $stmt->execute();
        $accountCheck = $stmt->fetch(PDO::FETCH_ASSOC);

        if(empty($accountCheck)) {
            $userExists = FALSE;
        } else {
            $userExists = TRUE;
        }
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

    if($userExists == FALSE) {

        $studentSQL  = "INSERT INTO Student (`StudentID`, `FirstName`, `LastName`, `Email`) VALUES (:firstName, :lastName, :email)";
        $userSQL = "INSERT INTO User (`StudentID`, `Password`, `isAdmin`) VALUES (:studentID, :password, :isAdmin)";

        try {
            if (isset($userInfo)) {
                $db   = getConnection();
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
                $db   = getConnection();
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
        }

        catch (PDOException $e) {
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    } else {
        echo '{"error":{"text": "An account with that email address already exists!"}}';
    }
}

function populateCustomer() {
    $userID      = "?????? Please Help";
    $sqlCustomer = "SELECT * From Customer WHERE CustomerID = $userID";
    try {
        $db       = getConnection();
        $stmt     = $db->query($sqlCustomer);
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
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getStudentInformation() {

	$sqlStudentProfile = "SELECT studentName, email, teamName FROM Student natural join involvement natural join team WHERE fname = $fname AND lname = $lname";
	try {
        $db       = getConnection();
        $stmt     = $db->query($sqlStudentProfile);
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
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }	
}

function getConnection() {
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "BurgerBar";
    $dbh    = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
/*
function getMenu() {
    $menu       = array();
    $sqlMeat    = "SELECT * FROM Meat";
    $sqlBun     = "SELECT * FROM Bun";
    $sqlCheese  = "SELECT * FROM Cheese";
    $sqlTopping = "SELECT * FROM Topping";
    $sqlSauce   = "SELECT * FROM Sauce";
    $sqlSide    = "SELECT * FROM Side";
    try {
        $db    = getConnection();
        $stmt  = $db->query($sqlMeat);
        $meats = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $meat     = array(
                'name' => $row['Name'],
                'price' => $row['Price']
            );
            $meats[ ] = $meat;
        }

        $menu['meats'] = $meats;
        $stmt          = $db->query($sqlBun);
        $buns          = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bun     = array(
                'name' => $row['Name'],
                'price' => $row['Price']
            );
            $buns[ ] = $bun;
        }

        $menu['buns'] = $buns;
        $stmt         = $db->query($sqlCheese);
        $cheeses      = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Name'] != 'None') {
                $cheese     = array(
                    'name' => $row['Name'],
                    'price' => $row['Price']
                );
                $cheeses[ ] = $cheese;
            }
        }

        $menu['cheeses'] = $cheeses;
        $stmt            = $db->query($sqlTopping);
        $toppings        = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $topping     = array(
                'name' => $row['Name'],
                'price' => $row['Price']
            );
            $toppings[ ] = $topping;
        }

        $menu['toppings'] = $toppings;
        $stmt             = $db->query($sqlSauce);
        $sauces           = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sauce     = array(
                'name' => $row['Name'],
                'price' => $row['Price']
            );
            $sauces[ ] = $sauce;
        }

        $menu['sauces'] = $sauces;
        $stmt           = $db->query($sqlSide);
        $sides          = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $side     = array(
                'name' => $row['Name'],
                'price' => $row['Price']
            );
            $sides[ ] = $side;
        }

        $menu['sides'] = $sides;
        echo json_encode($menu);
    }

    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//BurgerID is autoincremented, where are we getting OrderID from? Is that Inserted when order is made?
function makeBurger($meat, $cheese, $bun, $side) {
    $app        = \Slim\Slim::getInstance();
    $request    = $app->request();
 
    $burgerSQL  = "INSERT INTO Burger (Meat, Cheese, Bun, Side) VALUES
    							(:meat, :cheese, :bun, :side)";
    try {
        $db   = getConnection();
        $stmt = $db->prepare($burgerSQL);
        $stmt->bindParam("meat", $meat);
        $stmt->bindParam("cheese", $cheese);
        $stmt->bindParam("bun", $bun);
        $stmt->bindParam("side", $side);
        $success = $stmt->execute();
        if($success) {
            $burgerID = $db->lastInsertId();
            return $burgerID;
        } else {
            echo '{"error":{"text": "Error inside makeBurger()" }}';
            return null;
        }
        $db = null;
    }
    
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function makeOrder() {
	$app        = \Slim\Slim::getInstance();
    $request    = $app->request();
    //However the burger information is returned
    //$testJSON = '{"burgers":{"1":{"ID":1,"quantity":1,"meat":{"name":"1/2 lb. Beef","price":2.25},"bun":{"name":"Texas Toast","price":0.75},"cheese":{"name":"None","price":"0.00"},"toppings":[],"sauces":[],"side":{"name":"None","price":"0.00"},"cost":3},"2":{"ID":2,"quantity":1,"meat":{"name":"1/2 lb. Beef","price":2.25},"bun":{"name":"Texas Toast","price":0.75},"cheese":{"name":"None","price":"0.00"},"toppings":[],"sauces":[],"side":{"name":"None","price":"0.00"},"cost":3}},"Total":6,"customerID":1}';
    $orderInfo = json_decode($request->getBody());
    //$orderInfo = json_decode($testJSON);
    $customerID = $orderInfo->customerID;
    $orderTotal = $orderInfo->Total;
    $burgerInformation = $orderInfo->burgers;
    
    
    $orderDetailSQL  = "INSERT INTO OrderDetail VALUES (:BurgerID, :OrderID, :Quantity, :Cost)";
    $orderSQL = "INSERT INTO `Order` (CustomerID, Price) VALUES (:CustomerID, :Total)";
    $sqlTopping = "INSERT INTO ToppingDetail VALUES (:burgerID, :topping)";
    $sqlSauce   = "INSERT INTO SauceDetail VALUES (:burgerID, :sauce)";
    $sqlUpdateUser = "UPDATE Customer SET LastOrder = :lastOrder WHERE CustomerID = :customerID";
    $orderID = 0;
    
    try {
        $db = getConnection();
        $stmt = $db->prepare($orderSQL);
        $stmt->bindParam('CustomerID', $customerID);
        $stmt->bindParam('Total', $orderTotal);
        $success = $stmt->execute();

        if($success) {
            $orderID = $db->lastInsertId();
        } else {
            echo '{"error":{"text": "Bad things happened! JSON was not valid" }}';
        }

        foreach($burgerInformation as $burgerNumber=>$indiBurger)
        {
            $burgerID = makeBurger($indiBurger->meat->name, $indiBurger->cheese->name,
                $indiBurger->bun->name, $indiBurger->side->name);

            $stmt = $db->prepare($orderDetailSQL);
            $stmt->bindParam("BurgerID", $burgerID);
            $stmt->bindParam("OrderID", $orderID);
            $stmt->bindParam("Quantity", $indiBurger->quantity);
            $stmt->bindParam("Cost", $indiBurger->cost);
            $stmt->execute();

            $toppings = $indiBurger->toppings;
            foreach($toppings as $topping){
                $stmt2=$db->prepare($sqlTopping);
                $stmt2->bindParam("burgerID", $burgerID);
                $stmt2->bindParam("topping", $topping->name);
                $stmt2->execute();
                }

            $sauces = $indiBurger->sauces;
            foreach($sauces as $sauce){
                $stmt3 = $db->prepare($sqlSauce);
                $stmt3->bindParam("burgerID", $burgerID);
                $stmt3->bindParam("sauce", $sauce->name);
                $stmt3->execute();
                }
        }
        echo '{"status": "success", "OrderID": "' . $orderID . '"}';
    }
    
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getLastOrder() {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    $orderInfo = json_decode($request->getBody());
    $orderID = 1;
    $orderSQL = "SELECT * FROM `Order` WHERE OrderID = :orderID";
    $orderDetailSQL = "SELECT * FROM OrderDetail WHERE OrderID = :orderID";
    $burgerSQL = "SELECT * FROM Burger WHERE BurgerID = :burgerID";
    $toppingSQL = "SELECT * FROM ToppingDetail WHERE BurgerID = :burgerID";
    $sauceSQL = "SELECT * FROM SauceDetail WHERE BurgerID = :burgerID";

    $count = 1;

    $order = [];

    try {
        $db = getConnection();
        $stmt = $db->prepare($orderSQL);
        $stmt->bindParam('orderID', $orderID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $order['Total'] = $row['Price'];

        $stmt2 = $db->prepare($orderDetailSQL);
        $stmt2->bindParam('orderID', $orderID);
        $stmt2->execute();

        $burgers = [];
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $burgerID = $row['BurgerID'];
            $burger = [];
            $burger['quantity'] = $row['Quantity'];
            $burger['cost'] = $row['Cost'];

            $stmt3 = $db->prepare($burgerSQL);
            $stmt3->bindParam("burgerID", $burgerID);
            $stmt3->execute();
            $row = $stmt3->fetch(PDO::FETCH_ASSOC);

            $burger['meat'] = array('name' => $row['Meat']);
            $burger['bun'] = array('name' => $row['Bun']);
            $burger['cheese'] = array('name' => $row['Cheese']);
            $burger['side'] = array('name' => $row['Side']);

            $toppings = [];

            $stmt4 = $db->prepare($toppingSQL);
            $stmt4->bindParam('burgerID', $burgerID);
            $stmt4->execute();

            while($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
                $topping = array('name' => $row['Topping']);
                $toppings[] = $topping;
            }
            $burger['toppings'] = $toppings;

            $sauces = [];

            $stmt5 = $db->prepare($sauceSQL);
            $stmt5->bindParam('burgerID', $burgerID);
            $stmt5->execute();

            while($row = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                $sauce = array('name' => $row['Sauce']);
                $sauces[] = $sauce;
            }
            $burger['sauces'] = $sauces;

            $burgers[$count] = $burger;
            $count++;

        }

        $order['burgers'] = $burgers;

        echo json_encode($order);

    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

}

//Getting the last burger for a user
function getLastBurger($burgerIDNum) {
    $burgerID   = $burgerIDNum;
    $burgerSQL  = "SELECT * FROM Burger WHERE burgerID = $burgerID";
    $sqlTopping = "SELECT Topping FROM ToppingDetail WHERE BurgerID = $burgerID";
    $sqlSauce   = "SELECT Sauce FROM SauceDetail WHERE BurgerID = $burgerID";
    $lastBurger = array();
    try {
        $db   = getConnection();
        $stmt = $db->query($burgerSQL);
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lastBurger = array(
                'Meat' => $row['Meat'],
                'Cheese' => $row['Cheese'],
                'Bun' => $row['Bun'],
                'Side' => $row['Side']
            );
        }
        $stmt     = $db->query($sqlTopping);
        $toppings = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $topping     = array(
                'name' => $row['Name']
            );
            $toppings[ ] = $topping;
        }
        $lastBurger['toppings'] = $toppings;
        $stmt                   = $db->query($sqlSauce);
        $sauces                 = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sauce     = array(
                'name' => $row['Name']
            );
            $sauces[ ] = $sauce;
        }
        $lastBurger['sauces'] = $sauces;
        echo json_encode($lastBurger);
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//Getting the last Order from a user
function getLastOrder() {
	$app        = \Slim\Slim::getInstance();
    $request    = $app->request();
    //However the burger information is returned
    $user = json_decode($request->getBody());
    $orderSQL  = "SELECT BurgerID FROM OrderDetail natural join Burger where CustomerID=".$user['CustomerID'];
    $burgerIDs = array();
    try {
        $db   = getConnection();
        $stmt = $db->query($orderSQL);
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $burgerIDs = array(
                $row['BurgerID']
            );
        }
        forEach ($burgerIDs as $value) {
            getLastBurger($value);
        }
    }
    catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}
*/
?>

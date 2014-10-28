<?php
//These three lines deploy the slim framework
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

//Global variables for database connection (modify for your local machine)
$host = 'localhost';
$username = 'root';
$password = 'admin';
$dbname = 'BurgerBar';

// GET routes
$app->get('/', 'test');
//$app->get('/ingredients/:ingredient', 'getIngredients');
//$app->get('/lastOrder/:customerID', 'getLastOrder');

//$app->post('/createOrder', 'createOrder');

// POST routes
$app->post('/post', 'post');

// PUT routes
$app->put('/put', 'put');

// PATCH routes
$app->patch('/patch', 'patch');

// DELETE routes
$app->delete('/delete', 'delete');

// Functions for http routes
function test() {
    echo 'If you see this, Slim is working. :)';
}

function post() {
    echo 'This is a POST route';
}

function put() {
    echo 'This is a PUT route';
}

function patch() {
    echo 'This is a PATCH route';
}

function delete() {
    echo 'This is a DELETE route';
}

//Function to connect to database
function getDB() {
    global $host, $username, $password, $dbname;
    
    // Create connection to database
    $con = mysqli_connect($host, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    return $con;
}

function getConnection() {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "admin";
    $dbname = "BurgerBar";
    $dbh    = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>

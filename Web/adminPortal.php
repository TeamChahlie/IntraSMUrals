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
    <script src="js/adminModal.js"></script>

    <!-- CSS Files -->
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link href="css/navbar.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/modal.css" rel="stylesheet" type="text/css">
    <link href="css/adminModals.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php include "components/navbar.html"; include "components/modals.html"; include "components/adminModals.html"?>

    <div class="center">
        <div class="section">
            <h2 class="pageHeader">Admin Portal</h2>
            <div id="sportContainer">
                <div id="col1" class="sportViewContainer">
                    <div id="addNewSport">
                        <div class="sportDefault">
                            <h2 class="sportTitle">Add New Sport</h2>
                        </div>
                    </div>
<!--                    <div class="sportView">-->
<!--                        <div class="sportDefault">-->
<!--                            <h2 class="sportTitle">Basketball</h2>-->
<!--                        </div>-->
<!--                        <div class="sportOptionMenu">-->
<!--                            <div class="sportOptionButton editSport">Edit Sport</div>-->
<!--                            <div class="sportOptionButton deleteSport">Delete Sport</div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
                <div id="col2" class="sportViewContainer">

                </div>
                <div id="col3" class="sportViewContainer">

                </div>
                <div id="col4" class="sportViewContainer">

                </div>
            </div>
            <div style="{clear: both;}"></div>
        </div>
    </div>
</body>
</html>
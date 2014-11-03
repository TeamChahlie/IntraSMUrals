$(document).ready(function() {
    if (parseInt(sessionStorage.getItem('userID')) == 1 && sessionStorage.getItem('userID') != null) {
        window.location.replace("../redirect.php");
    }
});
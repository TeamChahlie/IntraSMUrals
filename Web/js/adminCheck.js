$(document).ready(function() {
    if (parseInt(sessionStorage.getItem('isAdmin')) == 0 || sessionStorage.getItem('isAdmin') == null) {
        window.location.replace("../redirect.php");
    }
});

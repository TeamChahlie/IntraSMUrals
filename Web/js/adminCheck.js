$(document).ready(function() {
    var userID = sessionStorage.getItem('userID');

    $.getJSON('api/adminCheck/' + userID, function(result) {
        if(result.isAdmin != null) {
            if(result.isAdmin == false) {
                window.location.replace('../redirect.php');
            }
        } else {
            alert(result.error.text);
            window.location.replace('../index.php');
        }
    });
});

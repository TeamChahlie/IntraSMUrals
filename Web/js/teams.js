


$(document).ready(function() {

    
    loadListofTeams();
    loadSpecificTeamInfo();

    if (parseInt(sessionStorage.getItem('userID')) != 1 && sessionStorage.getItem('userID') != null) {
        $('#navLoginForm').hide();
        $('#createAccount').hide();
        $('#loginInformation').show();
        $('#loginInformation').text("Welcome, " + sessionStorage.getItem("firstName") + "!");
        $('#logout').text("Logout").show();
        $('#mySports').show();
        if(parseInt(sessionStorage.getItem('isAdmin')) == 1) {
            $('#adminPortal').show();
        }

    } else {
        $('#adminPortal').hide();
    }

});

function loadListofTeams() {

    

    
}


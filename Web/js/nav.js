
$(document).ready(function() {

    addLoginClickListener();


    if (parseInt(sessionStorage.getItem('userID')) != 1 && sessionStorage.getItem('userID') != null) {
        console.log("FUCK");

        $('#navLoginForm').hide();
        $('#createAccount').hide();
        $('#loginInformation').text("Welcome, " + sessionStorage.getItem("firstName") + "!").show();
        $('#logout').text("Logout").show();
        $('#mySports').show();
    }

    var isAdmin = checkAdmin();
    if(isAdmin) {
        $('#adminPortal').show();
    } else {
        $('#adminPortal').hide();
    }

});

function addLoginClickListener() {
    $('#navLoginForm').submit(function() {
        var user = new Object();
        user.email = document.getElementById('navEmail').value;
        user.password = document.getElementById('navPassword').value;

        console.log(user.email);
        console.log(user.password);

        $.ajax({
            type: 'POST',
            url: 'api/login',
            content: 'application/json',
            data: JSON.stringify(user),
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);
                if(obj.info === false) {
                    $('#navEmail').val('');
                    $('#navPassword').val('');
                    alert("Username/Password are incorrect!");
                } else {
                    sessionStorage.setItem('userID', obj.info.studentID);
                    sessionStorage.setItem('firstName', obj.info.fname);
                    sessionStorage.setItem('lastName', obj.info.lname);
                    sessionStorage.setItem('email', user.email);
                    console.log(sessionStorage);

                    $('#navLoginForm').hide();
                    $('#createAccount').hide();
                    $('#loginInformation').show();
                    $('#loginInformation').text("Welcome, " + sessionStorage.getItem("firstName") + "!");
                    $('#logout').text("Logout").show();
                    $('#mySports').show();

                    if(parseInt(obj.info.isAdmin) == 1) {
                        $('#adminPortal').show();
                    }
                }
            },
            error: function() {
                console.log("Oh no! Someone dun goofd :-P");
            }
        });
        return false;
    });
}

function checkAdmin() {
    var userID = sessionStorage.getItem('userID');
    if(userID != 1) {
        $.getJSON('api/adminCheck/' + userID, function(result) {
            console.log("HERE");
            if(result.isAdmin != null) {
                console.log(result.isAdmin);
                if(result.isAdmin == false) {
                    return false;
                } else if(result.isAdmin == true) {
                    return true;
                }
            } else {
                console.log("ERROR");
                return false;
            }
        });
    } else {
        return false;
    }

}


$(document).ready(function() {

    populateSportMenu();
    addLoginClickListener();


    if (parseInt(sessionStorage.getItem('userID')) != 1 && sessionStorage.getItem('userID') != null) {

        $('#navLoginForm').hide();
        $('#createAccount').hide();
        $('#loginInformation').text("Welcome, " + sessionStorage.getItem("firstName") + "!").show();
        $('#logout').text("Logout").show();
        $('#mySports').show();
    }

    checkAdmin();

});

function populateSportMenu() {
    var sportDropDown = document.getElementById('sportDropdown');
    $.getJSON('/api/getAllSports', function(sports) {
        sessionStorage.setItem("sports", JSON.stringify(sports));
        for(var i = 0; i < sports.length; i++) {
            var li = document.createElement('li');
            sportDropDown.appendChild(li);

            var a = document.createElement('a');
            a.textContent = sports[i];
            a.href = "/sportHome.php?sport=" + sports[i];
            li.appendChild(a);
        }
    });
}

function addLoginClickListener() {
    $('#navLoginForm').submit(function() {
        var user = new Object();
        user.email = document.getElementById('navEmail').value;
        user.password = document.getElementById('navPassword').value;


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
    var userID = parseInt(sessionStorage.getItem('userID'));
    if(userID != 1) {
        $.getJSON('api/adminCheck/' + userID, function(result) {
            if(result.isAdmin != null) {
                if(result.isAdmin) {
                    $('#adminPortal').show();
                } else {
                    $('#adminPortal').hide();
                }
            } else {
                console.log("ERROR");
                $('#adminPortal').hide();
            }
        });
    } else {
        $('#adminPortal').hide();
    }
}

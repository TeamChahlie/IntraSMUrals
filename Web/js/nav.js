


$(document).ready(function() {

    addLoginClickListener();
    addLogoutClickListener();

    if (parseInt(sessionStorage.getItem('userID')) != 1 && sessionStorage.getItem('userID') != null) {
        $('#navLoginForm').hide();
        $('#createAccount').hide();
        $('#loginInformation').show();
        $('#loginInformation').text("Welcome, " + sessionStorage.getItem("firstName") + "!");
        $('#logout').text("Logout").show();

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
                    sessionStorage.setItem('firstName', obj.info.FirstName);
                    sessionStorage.setItem('lastName', obj.info.LastName);
                    sessionStorage.setItem('email', user.email);
                    sessionStorage.setItem('password', user.password);
                    sessionStorage.setItem('ccProvider', obj.info.CreditCardProvider);
                    sessionStorage.setItem('ccNumber', obj.info.CreditCardNumber);
                    sessionStorage.setItem('lastOrder', obj.info.LastOrder);
                    console.log(sessionStorage);

                    $('#signIn').hide();
                    $('#checkoutAsGuest').hide();
                    $('#checkout').show();
                    $('#reorder').show();

                    $('#navLoginForm').hide();
                    $('#createAccount').hide();
                    $('#loginInformation').show();
                    $('#loginInformation').text("Welcome, " + sessionStorage.getItem("firstName") + "!");
                    $('#logout').text("Logout").show();
                }
            },
            error: function() {
                console.log("Oh no! Someone dun goofd :-P");
            }
        });
        return false;
    });
}

function addLogoutClickListener() {
    $('#logout').click(function() {
        sessionStorage.setItem('userID', 1);
        sessionStorage.removeItem('firstName');
        sessionStorage.removeItem('lastName');
        sessionStorage.removeItem('email');
        sessionStorage.removeItem('password');
        sessionStorage.removeItem('ccProvider');
        sessionStorage.removeItem('ccNumber');
        sessionStorage.removeItem('lastOrder');
        console.log(sessionStorage);

        $('#signIn').show();
        $('#checkoutAsGuest').show();
        $('#checkout').hide();
        $('#reorder').hide();

        $('#navLoginForm').show();
        $('#createAccount').show();
        $('#navEmail').val('');
        $('#navPassword').val('');

        $('#loginInformation').text('').hide();
        $('#logout').text('').hide();

    });
}
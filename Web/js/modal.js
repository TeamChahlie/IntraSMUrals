$(document).ready(function() {

    $('#createAccount').click(function() {
        showAccountModal();
    });

    $('.closeButton').click(function() {
        hideModals();
    });

    $('#overlay').click(function() {
        hideModals();
    });

    $(document).on('submit', 'form.accountForm', function(event) {
        event.preventDefault();
        createAccount();
    });

});

function showAccountModal() {
    displayModal('accountModal');
}

function displayModal(modalID) {
    var modal = document.getElementById(modalID)
    var background = document.getElementById('overlay');
    background.className = 'overlay'
    modal.className = 'displayModal';
    var width = modal.clientWidth;
    var height = modal.clientHeight;
    var displacementX = '-'+ (width/2) + 'px';
    var displacementY = '-' + (height/2) + 'px';
    modal.style.marginLeft = displacementX;
    modal.style.marginTop = displacementY;
}

function hideModals() {
    document.getElementById('accountModal').className = 'modal';
    document.getElementById('overlay').className = '';
}

function createAccount() {

    var password = $('#accountPassword').val();
    var confirmpassword = $('#accountPassword2').val();

    if (password != confirmpassword) {
        alert("Passwords did not match");
    } else {
        var user = new Object();
        user.FirstName = $('#accountFirstName').val();
        user.LastName = $('#accountLastName').val();
        user.StudentID = $('#accountID').val();
        user.Email = $('#accountEmail').val();
        user.Password = $('#accountPassword').val();

        $.ajax({
            type: 'POST',
            url: 'api/register',
            content: 'application/json',
            data: JSON.stringify(user),
            success: function(data) {
                console.log(data);
                var obj = JSON.parse(data);

                if(obj.info == false) {
                    alert("Registration failed.");
                } else if (obj.error != undefined) {
                    alert(obj.error.text);
                } else {
                    alert("SUCCESS!");

                    hideModals();
                }
            },
            error: function() {
                alert("U DUN GOOFED.");
            }
        })
    }
}
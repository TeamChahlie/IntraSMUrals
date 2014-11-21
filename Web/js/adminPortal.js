

$(document).ready(function() {
    addClickListeners()
});


function addClickListeners() {
    $('.adminButton').click(function() {
        var buttons = document.getElementsByClassName('adminButtonSelected');
        for(var button in buttons) {
            buttons[button].className = "adminButton";
        }
        this.className = "adminButtonSelected";

        var id = $(this)[0].id;
        id += "Form";
        hideForms();
        displayForm(id);
    });

    $('#submitSport').click(function(event) {
        event.preventDefault();
        var sportName = $('#createSportName').val();
        console.log(sportName);
        var sport = new Object();
        sport.sportName = sportName;
        $.ajax({
            type: 'POST',
            url: 'api/insertSport',
            content: 'application/json',
            data: JSON.stringify(sport),
            success: function(data) {
                var obj = JSON.parse(data);
                if(obj.success == true) {
                    alert("Created Sport '" + sportName + "'!");
                }
            },
            error: function() {
                alert("YOU DUN GOOFED");
            }
        });
    });
}

function displayForm(formID) {
    var form = document.getElementById(formID);
    form.className = "displayAdminForm";
}

function hideForms() {
    var forms = document.getElementsByClassName('displayAdminForm');
    for(var form in forms) {
        console.log(forms[form]);
        forms[form].className = "adminForm";
    }
}
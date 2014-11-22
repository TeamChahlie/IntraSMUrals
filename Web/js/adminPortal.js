
$(document).ready(function() {
    populateSports();
    addClickListeners();
    addChosenJS();
});

function populateSports() {
    $.getJSON('api/getSportList', function(sports) {

    });
}

function addClickListeners() {
    $('.sportView').click(function() {
        $('.sportViewSelected').animate({ height: '-=50px'}, 400);
        $(this).children('.sportOptionMenu').hide();
        var buttons = document.getElementsByClassName('sportViewSelected');
        for(var button in buttons) {
            buttons[button].className = "sportView";
        }
        this.className = "sportViewSelected";

        if($(this).css('display') == 'block') {
            console.log("TRUE");
        } else {
            $(this).animate({ height: '+=50px'}, 400);
            $(this).children('.sportOptionMenu').show();
        }
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

    $('.sportView').click(function() {

    });

}

function addChosenJS() {

}

function displayForm(formID) {
    var form = document.getElementById(formID);
    form.className = "displayAdminModal";
}

function hideForms() {
    var forms = document.getElementsByClassName('displayAdminModal');
    for(var form in forms) {
        console.log(forms[form]);
        forms[form].className = "adminModal";
    }
}
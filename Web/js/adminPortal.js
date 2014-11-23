
$(document).ready(function() {
    populateSports();
    addClickListeners();
    addHoverListeners();
    addChosenJS();
});

function populateSports() {
    $.getJSON('api/getSportList', function(sports) {

    });
}

function addClickListeners() {

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

    $('.editSport').click(function() {
        console.log("EDIT SPORT");
    });

    $('.deleteSport').click(function() {
        console.log("DELETE SPORT");
    });

}

function addHoverListeners() {
    $('.sportView').hover(function() {
        $(this).children('.sportDefault').animate({width: 'toggle'}, 200);
        $(this).children('.sportOptionMenu').animate({width: 'toggle'}, 300);
    }, function() {
        $(this).children('.sportOptionMenu').animate({width: 'toggle'}, 200);
        $(this).children('.sportDefault').animate({width: 'toggle'}, 300);
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
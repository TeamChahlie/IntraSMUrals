
var currentSport = "";

$(document).ready(function() {
    populateSports();
    addClickListeners();
    addHoverListeners();
});

function populateSports() {
    $.getJSON('api/getSportList', function(sports) {
        var currentCol = 2;
        for(var sport in sports) {
            var sportInfo = sports[sport];
            console.log(currentCol);
            columnString = "col" + currentCol;
            console.log(columnString);
            var column = document.getElementById(columnString);
            console.log(column);
            var newDiv = document.createElement('div');
            newDiv.className = "sportView";
            column.appendChild(newDiv);

            var div1 = document.createElement('div');
            div1.className = "sportDefault";
            newDiv.appendChild(div1);

            var sportTitle = document.createElement('h2');
            sportTitle.className = "sportTitle truncate";
            sportTitle.textContent = sportInfo.sportName;
            div1.appendChild(sportTitle);

            var teamNumber = document.createElement('p');
            teamNumber.className = "";
            teamNumber.textContent = sportInfo.teamCount + " teams registered";
            div1.appendChild(teamNumber);

            var div2 = document.createElement('div');
            div2.className = "sportOptionMenu";
            newDiv.appendChild(div2);

            var editDiv = document.createElement('div');
            editDiv.className = "sportOptionButton editSport";
            editDiv.textContent = "Edit Sport";
            div2.appendChild(editDiv);

            var deleteDiv = document.createElement('div');
            deleteDiv.className = "sportOptionButton deleteSport";
            deleteDiv.textContent = "Delete Sport";
            div2.appendChild(deleteDiv);

            currentCol = currentCol + 1;

            if(currentCol > 4) {
                currentCol = 1;
            }
        }

    });
}

function addClickListeners() {
    $('.sportViewContainer').on('click', 'div.editSport', function() {
        var sportName = $(this).parent().prev().children('.sportTitle').text();
        var url = "editSport.php?sportName=" + sportName;
        window.location.href = url;
    });

    $('.sportViewContainer').on('click', 'div.deleteSport', function() {
        var sportName = $(this).parent().prev().children('.sportTitle').text();
        var sport = new Object();
        sport.sportName = sportName;
        currentSport = sport;
        displayConfirmationModal();

    });

    $('#yesDelete').click(function() {
        $.ajax({
            type: 'POST',
            url: 'api/deleteSport',
            content: 'application/json',
            data: JSON.stringify(currentSport),
            success: function(data) {
                window.location.href = "adminPortal.php";
            },
            error: function() {
                alert("Error in AJAX request.")
            }
        });
    });

    $('#noDelete').click(function() {
        hideConfirmationModal();
    });
}



function addHoverListeners() {
    $('.sportViewContainer').on('mouseenter', 'div.sportView', function() {
        $(this).children('.sportDefault').animate({width: 'toggle'}, 200);
        $(this).children('.sportOptionMenu').animate({width: 'toggle'}, 300);
    });
    $('.sportViewContainer').on('mouseleave', 'div.sportView',function() {
        $(this).children('.sportOptionMenu').animate({width: 'toggle'}, 200);
        $(this).children('.sportDefault').animate({width: 'toggle'}, 300);
    });
}

function displayConfirmationModal() {
    var modal = document.getElementById('deleteSportModal')
    var background = document.getElementById('adminOverlay');
    background.className = 'adminOverlay';
    modal.className = 'displayAdminModal';
    var width = modal.clientWidth;
    var height = modal.clientHeight;
    var displacementX = '-'+ (width/2) + 'px';
    var displacementY = '-' + (height/2) + 'px';
    modal.style.marginLeft = displacementX;
    modal.style.marginTop = displacementY;
}

function hideConfirmationModal() {
    var forms = document.getElementsByClassName('displayAdminModal');
    for(var form in forms) {
        forms[form].className = "adminModal";
    }
    document.getElementById('adminOverlay').className = "";
}


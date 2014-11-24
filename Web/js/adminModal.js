$(document).ready(function() {

    $('#addNewSport').click(function() {
        displayAdminModal('addSportModal');
    });

    $('#createSportForm').submit(function(event) {
        event.preventDefault();
        submitSport();
    });

    $('#addNewTeam').click(function() {
        displayAdminModal('addTeamModal');
    });

    $('#createTeamForm').submit(function(event) {
        event.preventDefault();
        submitTeam();
    })

    $('#adminOverlay').click(function() {
        hideAdminModals();
    });

    $('.adminCloseButton').click(function() {
        hideAdminModals();
    });

});

function displayAdminModal(modalID) {
    var modal = document.getElementById(modalID)
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

function hideAdminModals() {
    var forms = document.getElementsByClassName('displayAdminModal');
    for(var form in forms) {
        forms[form].className = "adminModal";
    }
    document.getElementById('adminOverlay').className = "";
}

function submitSport() {
    var sportName = $('#createSportName').val();
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
                hideAdminModals();
                window.location.href = "editSport.php?sportName=" + sportName;
            } else {
                alert("Error inserting new sport into database.")
            }
        },
        error: function() {
            alert("Error during AJAX request.");
        }
    })
}

function submitTeam() {
    var teamName = $('#createTeamName').val();
    var sportName = sessionStorage.getItem('currentSport');

    var team = new Object();
    team.teamName = teamName;
    team.sportName = sportName;

    $.ajax({
        type: 'POST',
        url: 'api/insertTeam',
        content: 'application/json',
        data: JSON.stringify(team),
        success: function(data) {
            if(data.success == true) {
                hideAdminModals();
                window.location.href = "editSport.php?sportName=" + sportName;
            } else {
                alert("Error inserting team into DB.");
            }
        },
        error: function() {
            alert("Error in AJAX request.");
        }
    })
}
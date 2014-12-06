$(document).ready(function() {

    prepSelectBoxes();

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
    });

    $('#addNewMatch').click(function() {
        displayAdminModal('addMatchModal');
    });

    $('#addNewGame').click(function() {
        displayAdminModal('addGameModal');
    });

    $('#createMatchForm').submit(function(event) {
        event.preventDefault();
        submitMatch();
    });

    $('#updateScoresForm').submit(function(event) {
        event.preventDefault();
        updateScores();
    });

    $('#adminOverlay').click(function() {
        hideAdminModals();
    });

    $('.adminCloseButton').click(function() {
        hideAdminModals();
    });

    $('#teamSelect1').on('change', function() {
        var val = $(this).val();
        var count = 0;
        $('#teamSelect2').children().each(function() {
            if(count > 0) {
                $(this).prop('disabled', false);
            }
            if($(this).val() == val) {
                $(this).prop('disabled', true);
            }
            count++;
        });
    });

    $('#teamSelect2').on('change', function() {
        var val = $(this).val();
        var count = 0;
        $('#teamSelect1').children().each(function() {
            if(count > 0) {
                $(this).prop('disabled', false);
            }
            if($(this).val() == val) {
                $(this).prop('disabled', true);
            }
            count++;
        });
    });

});

function prepSelectBoxes() {
    var select1 = document.getElementById('teamSelect1');
    var select2 = document.getElementById('teamSelect2');

    var teams = JSON.parse(sessionStorage.getItem('teams'));
    for(var key in teams) {
        var team = teams[key];

        var option = document.createElement('option');
        option.value = team.teamName;
        option.textContent = team.teamName;
        select1.appendChild(option);

        var option2 = document.createElement('option');
        option2.value = team.teamName;
        option2.textContent = team.teamName;
        select2.appendChild(option2);
    }
}

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
            console.log(data);
            var obj = JSON.parse(data);
            if(obj.success == true) {
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

function submitMatch() {
    var sportName = sessionStorage.getItem('currentSport');
    var team1 = document.getElementById('teamSelect1').value;
    var team2 = document.getElementById('teamSelect2').value;
    var date = document.getElementById('createMatchDate').value;
    var time = document.getElementById('createMatchTime').value;
    time += ":00";

    var match = new Object();
    match.sportName = sportName;
    match.teamA = team1;
    match.teamB = team2;
    match.dateOf = date;
    match.timeOf = time;

    $.ajax({
        type: 'POST',
        url: 'api/insertMatch',
        content: 'application/json',
        data: JSON.stringify(match),
        success: function(data) {
            var obj = JSON.parse(data);
            if(obj.success == true) {
                window.location.href= "editSport.php?sportName=" + sportName;
            } else {
                alert("Error inserting match into DB.");
            }
        },
        error: function() {
            alert("Error in AJAX request.")
        }
    });

}

function updateScores() {
    var match = JSON.parse(sessionStorage.getItem('currentMatch'));
    match.teamAScore = parseInt(document.getElementById('updateScore1').value);
    match.teamBScore = parseInt(document.getElementById('updateScore2').value);

    $.ajax({
        type: 'POST',
        url: 'api/updateMatchScore',
        content: 'application/json',
        data: JSON.stringify(match),
        success: function(data) {
            var obj = JSON.parse(data);
            if(obj.success == true) {
                if(get("sportName")) {
                    window.location.href = "editSport.php?sportName=" + get('sportName');
                } else {
                    window.location.href = "editTeam.php?teamName=" + get('teamName');
                }
            } else {
                alert("Error updating match scores in DB.");
            }
        },
        error: function() {
            alert("Error in AJAX request.");
        }
    });
}
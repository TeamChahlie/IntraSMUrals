
var teams = new Object();

$(document).ready(function() {

    prepSelectBoxes();
    teams = JSON.parse(sessionStorage.getItem("teams"));
    console.log(teams);

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
        var currentTeam = sessionStorage.getItem('currentTeam');
        console.log(currentTeam);
        $("option[value='" + currentTeam + "']")
            .attr("disabled", "disabled")
            .siblings().removeAttr("disabled");
        $("option[value='Opponent']")
            .attr("disabled", "disabled")
        displayAdminModal('addGameModal');
    });

    $('#createGameForm').submit(function(event) {
        event.preventDefault();
        submitGame();
    });

    $('#addNewPlayers').click(function() {
        displayAdminModal('addPlayersModal');
    });

    $('#addPlayersForm').submit(function(event) {
        event.preventDefault();
        addPlayers();
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
    var select3 = document.getElementById('teamSelect');
    var teams = JSON.parse(sessionStorage.getItem('teams'));
    for(var key in teams) {
        var team = teams[key];

        var option = document.createElement('option');
        option.value = team.teamName;
        option.textContent = team.teamName;
        select1.appendChild(option);
        select2.appendChild(option);
        select3.appendChild(option);
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

function submitGame() {
    var sportName = sessionStorage.getItem('currentSport');
    var team1 = sessionStorage.getItem('currentTeam');
    var team2 = document.getElementById('teamSelect').value;
    var date = document.getElementById('createGameDate').value;
    var time = document.getElementById('createGameTime').value;

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
	    console.log(obj);
            if(obj.success == true) {
                window.location.href= "editTeam.php?teamName=" + team1;
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

function addPlayers() {
    var teamName = sessionStorage.getItem('currentTeam');
    var teamID = "";
    for (var key in teams) {
        var team = teams[key];
        if (team.teamName == teamName) {
            teamID = team.teamID;
        }
    }

    var text = document.getElementById('playerIDs').value;
    var studentIDs = text.split('\n');
    var badResults = [];
    for (var key in studentIDs) {
        var id = studentIDs[key];
        id = $.trim(id);
        console.log(id);
        if(id.length != 8) {
            badResults.push(id);
        } else {
            var student = new Object();
            student.teamID = teamID;
            student.studentID = id;
            $.ajax({
                type: 'POST',
                url: 'api/insertStudent',
                content: 'application/json',
                data: JSON.stringify(student),
                success: function(data) {
                    var obj = JSON.parse(data);
                    if(obj.success == false) {
                        badResults.push(id);
                    }
                },
                error: function() {
                    badResults.push(id);
                    console.log("ERROR");
                }
            });
        }
    }

    if(badResults.length > 0) {
        alert("One or more IDs were not added to the team. They either had an incorrect length or do not have an account in the database.\n" + badResults);
    } else {
        window.location.href = "editTeam.php?teamName=" + get('teamName');
    }
}

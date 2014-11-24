$(document).ready(function() {
    $('.subHeader').text(get('sportName'));

    getTeams();
    addTeamHoverListeners();
});

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}

function getTeams() {
    $.getJSON('api/getTeamsInSport/' + get('sportName'), function(teams) {

        if(teams.length > 0) {
            for(var team in teams) {
                var teamName = teams[team].teamName;
                var teamList = document.getElementById('sportTeamList');

                var div = document.createElement('div');
                div.className = "teamEditorButton";
                teamList.appendChild(div);

                var subDiv1 = document.createElement('div');
                subDiv1.className = "teamDefault";
                div.appendChild(subDiv1);

                var h2 = document.createElement('h2');
                h2.className = "teamTitle";
                h2.textContent = teamName;
                subDiv1.appendChild(h2);

                var subDiv2 = document.createElement('div');
                subDiv2.className = "teamOptionMenu";
                div.appendChild(subDiv2);

                var editDiv = document.createElement('div');
                editDiv.className = "teamOptionButton editTeam";
                editDiv.textContent = "Edit";
                subDiv2.appendChild(editDiv);

                var deleteDiv = document.createElement('div');
                deleteDiv.className = "teamOptionButton deleteTeam";
                deleteDiv.textContent = "Delete";
                subDiv2.appendChild(deleteDiv);

            }
        }
    });
}

function addTeamHoverListeners() {
    $('#sportTeamList').on('mouseenter', '.teamEditorButton', function() {
        $(this).children('.teamDefault').stop().animate({width: 'toggle'}, 200);
        $(this).children('.teamOptionMenu').stop().animate({width: 'toggle'}, 300);
    });
    $('#sportTeamList').on('mouseleave', '.teamEditorButton', function() {
        $(this).children('.teamOptionMenu').stop().animate({width: 'toggle'}, 200);
        $(this).children('.teamDefault').stop().animate({width: 'toggle'}, 300);
    });
}
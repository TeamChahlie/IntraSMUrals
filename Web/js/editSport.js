$(document).ready(function() {
    $('.subHeader').text(get('sportName'));

    getTeams();
});

function get(name){
    if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}

function getTeams() {
}
$(document).ready(function() {

    $('#createAccount').click(function() {
        showAccountModal();
    });

});

function showAccountModal() {
    displayModal('accountModal');
}

function displayModal(modalID) {
    var modal = document.getElementById(modalID)
    var background = document.getElementById("overlay");
    background.className = "overlay"
    modal.className = "displayModal";
    var width = modal.clientWidth;
    var height = modal.clientHeight;
    var displacementX = '-'+ (width/2) + 'px';
    var displacementY = '-' + (height/2) + 'px';
    modal.style.marginLeft = displacementX;
    modal.style.marginTop = displacementY;
}


$(document).ready(function() {
    addClickListeners()
});


function addClickListeners() {
    $('.adminButton').click(function() {
        console.log("CLICK");
        var buttons = document.getElementsByClassName('adminButtonSelected');
        for(var button in buttons) {
            buttons[button].className = "adminButton";
        }
        this.className = "adminButtonSelected";
    })
}
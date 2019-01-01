
//Call ajax every 1 minute

var interval = 1000 * 60 * 1; // where X is your every X minutes
setInterval(function() {
    $.ajax({
        url: "/timer/online",
        type: "GET",
        success: function (data) {
        }
    });
}, interval);

var hasLumberjackSaidBye = false;
var lumberjackBye = function() {
    if (!hasLumberjackSaidBye) return true;
    navigator.sendBeacon('/lumberjack/bye');
    var until = new Date()
        .getTime() + 100;
    while (new Date()
        .getTime() < until);
    hasLumberjackSaidBye = true;
};
document.addEventListener('visibilitychange', function logData() {
    if (document.visibilityState === 'hidden') {
        lumberjackBye();
    } else {
        hasLumberjackSaidBye = false;
    }
});
window.onbeforeunload(function() {
    lumberjackBye();
});
window.onunload(function() {
    lumberjackBye();
});

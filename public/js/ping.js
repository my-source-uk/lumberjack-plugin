var hasLumberjackSaidBye = false;
const csrf = document.head.querySelector('meta[name="csrf-token"]');
let data = new FormData();
data.append('_token', csrf.content);
var lumberjackBye = function() {
    if (hasLumberjackSaidBye) return true;
    navigator.sendBeacon('/lumberjack/bye', data);
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
window.onbeforeunload = function() {
    return lumberjackBye();
};
window.onunload = function() {
    return lumberjackBye();
};

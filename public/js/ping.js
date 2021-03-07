window.addEventListener('beforeunload', function(event) {
    // or 'unload'
    navigator.sendBeacon('/lumberjack/bye');
    // more safely (optional...?)
    var until = new Date()
        .getTime() + 100;
    while (new Date()
        .getTime() < until);
});

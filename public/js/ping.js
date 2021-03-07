document.addEventListener('visibilitychange', function logData() {
    if (document.visibilityState === 'hidden') {
        navigator.sendBeacon('/lumberjack/bye');
        var until = new Date()
            .getTime() + 100;
        while (new Date()
            .getTime() < until);
    }
});

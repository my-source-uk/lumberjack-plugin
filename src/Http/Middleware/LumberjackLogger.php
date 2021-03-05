<?php

namespace Lumberjack\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Lumberjack\Jobs\LumberjackLoggerJob;
use Carbon\Carbon;

class LumberjackLogger
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request Request instance.
     * @param \Closure                 $next    Closure
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ('1' === $request->header('DNT')) {
            // Skip if Do Not Track is set.
            return $next($request);
        }

        // Process the incoming path:
        $pathname = ('/' === $request->path()) ? '/' : '/'.$request->path();
        $hostname = ('/' !== $pathname) ? Str::before($request->url(), $pathname) : $request->url();
        // Determine if we have an external referer:
        $referrer = $request->header('referer');
        if (true === Str::contains($referrer, Config::get('app.url'))) {
            $referrer = '';
        }

        // Compile base data array.
        $data = [
            'salt' => hash('sha256', Config::get('lumberjack.siteId').date('z')),
            'referrer' => $referrer,
            'agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
            'site_id' => Config::get('lumberjack.siteId'),
            'hostname' => $hostname,
            'pathname' => $pathname,
            'timestamp' => Carbon::now('UTC')->startOfHour(),
        ];

        // Build the two hashes.
        $user_signature = hash('sha512', $data['salt'].$data['ip'].$data['agent'].$data['site_id'].$data['hostname']);
        $page_signature = hash('sha512', $user_signature.$data['pathname']);

        // Determine the device and browser type.
        $data['mobile'] = Str::contains($data['agent'], 'Mobi');
        $browsers = [
            'Seamonkey' => '/Seamonkey\/([0-9\.]*)/i',
            'Firefox' => '/Firefox\/([0-9\.]*)/i',
            'Safari' => '/Safari\/([0-9\.]*)/i',
            'Chromium' => '/Chromium\/([0-9\.]*)/i',
            'Chrome' => '/Chrome\/([0-9\.]*)/i',
            'Opera' => '/OPR|Opera\/([0-9\.]*)/i',
            'Internet Explorer' => '/; (?:MSIE |Trident\/7\.0\; rv\:)([0-9\.]*)/i',
        ];
        // Note: do not change order - it is very important!

        $data['browser'] = [
            'name' => 'Unknown',
            'version' => '0.0',
        ];

        foreach ($browsers as $browser => $search) {
            $result = Str::of($data['agent'])->match($search);
            if (false !== $result->isNotEmpty()) {
                $data['browser'] = [
                    'name' => $browser,
                    'version' => $result,
                ];

                continue;
            }
        }

        // Remove some dangerous data.
        unset($data['agent']);
        unset($data['salt']);
        unset($data['ip']);

        // Add the hashes to the package.
        $data = array_merge($data, compact('user_signature', 'page_signature'));

        // Dispatch the job.
        LumberjackLoggerJob::dispatch($data);
        // LumberjackLoggerJob::dispatchAfterResponse($data);

        // Continue with the request.
        return $next($request);
    }
}

<?php

namespace Lumberjack\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Lumberjack\Contracts\BrowserRepository;
use Lumberjack\Contracts\DeviceRepository;
use Lumberjack\Contracts\ReferrerRepository;
use Lumberjack\Contracts\RequestRepository;
use Lumberjack\Contracts\VisitorRepository;
use Throwable;

class LumberjackLoggerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Data to add to the database.
     *
     * @var string
     */
    protected $data;

    /**
     * Device Repository.
     *
     * @var DeviceRepository
     */
    protected $deviceRepo;

    /**
     * Request Repository.
     *
     * @var RequestRepository
     */
    protected $requestRepo;

    /**
     * Referrer Repository.
     *
     * @var ReferrerRepository
     */
    protected $referrerRepo;

    /**
     * Visitor Repository.
     *
     * @var VisitorRepository
     */
    protected $visitorRepo;

    /**
     * Browser Repository.
     *
     * @var BrowserRepository
     */
    protected $browserRepo;

    /**
     * Create a new job instance.
     *
     * @param array $data Data to add.
     *
     * @return void
     */
    public function __construct(
        array $data
    ) {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param RequestRepository  $request  Request repository.
     * @param VisitorRepository  $visitor  Visitor repository.
     * @param ReferrerRepository $referrer Referrer repository.
     * @param DeviceRepository   $device   Device repository.
     * @param BrowserRepository  $browser  Browser repository.
     *
     * @return void
     */
    public function handle(
        RequestRepository $request,
        VisitorRepository $visitor,
        ReferrerRepository $referrer,
        DeviceRepository $device,
        BrowserRepository $browser
    ) {
        // Step 1 - Start with checking for visitor uniqueness
        $uniqueVisitor = $visitor->isUnique($this->data['hashes']['user']);

        // Step 2 - Referrer
        if ('' !== $this->data['referrer']) {
            $referrer->create($this->data['referrer']);
        }

        // Step 3 - Device & Browser (when unique visitor)
        if (true === $uniqueVisitor) {
            // Step 3a - Device Type
            if (true === $this->data['mobile']) {
                $device->increment('mobile');
            } else {
                $device->increment('desktop');
            }
            // Step 3b - Browser and version
            $browser->increment($this->data['browser']);
        }

        // Step 4 - Add the page request entry
        $request->add($this->data);
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception Throwable error.
     *
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Log::emergency("Lumberjack Logger Job Failed!\n".$exception->getMessage());
    }
}

<?php

namespace App\Jobs;

use App\Models\User;
use Croustibat\FilamentJobsMonitor\Traits\QueueProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class UpdateCurrenciesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, QueueProgress, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->notifyJobCreated();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->notifyJobStarted();
        Artisan::call('currencies:update');
        $this->notifyJobFinished();
    }

    protected function notifyJobCreated()
    {
        $recipient = Auth::user();

        Notification::make()
            ->title('Currency Update Job Created')
            ->body('A new currency update job has been created.')
            ->sendToDatabase($recipient);
    }

    protected function notifyJobStarted()
    {
        $recipient = User::first();

        Notification::make()
            ->title('Currency Update Job Started')
            ->body('The currency update job has started.')
            ->sendToDatabase($recipient);
    }

    protected function notifyJobFinished()
    {
        $recipient = User::first();
        Log::info($recipient);
        Notification::make()
            ->title('Currency Update Job Finished')
            ->body('The currency update job has finished.')
            ->sendToDatabase($recipient);
    }
}

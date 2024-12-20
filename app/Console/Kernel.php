<?php

namespace App\Console;

use App\Jobs\FeePastDueCalculation;
use App\Jobs\FinancialYearJob;
use App\Jobs\LoanPenaltCalculation;
use App\Jobs\StockPastDueCalculation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->job(new StockPastDueCalculation)->dailyAt('23:55');
        // $schedule->job(new FeePastDueCalculation)->dailyAt('23:58');
        // $schedule->job(new LoanPenaltCalculation)->dailyAt('23:50');
        $schedule->call(function () {
            LoanPenaltCalculation::dispatch()->onQueue('emails');
        })->dailyAt('23:50');

        $schedule->call(function () {
            StockPastDueCalculation::dispatch()->onQueue('emails');
        })->dailyAt('23:58');

        $schedule->call(function () {
            FeePastDueCalculation::dispatch()->onQueue('emails');
        })->dailyAt('23:50');

        $schedule->call(function () {
            FinancialYearJob::dispatch()->onQueue('emails');
        })->yearlyOn(12, 25, '00:00');;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

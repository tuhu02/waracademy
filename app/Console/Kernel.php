<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		\App\Console\Commands\UpdateTournamentStatus::class,
	];

	/**
	 * Define the application's command schedule.
	 */
	protected function schedule(Schedule $schedule)
	{

	}

	/**
	 * Register the commands for the application.
	 */
	protected function commands()
	{
		// Load commands from the Commands directory
		$this->load(__DIR__ . '/Commands');
	}
}

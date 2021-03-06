<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Database\QueryException;

use App\Site;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

		// :00 :20 :40 Ping all the update URLs for site/variable       
        // Limit to Red Butte sites
		$siteCodeContains = ['RB_'];
		// $siteCodeContains = ['RB_', 'PR_', 'LR_'];
		try {
			foreach($siteCodeContains as $piece) {
				$sites = Site::where('sitecode', 'LIKE', '%' . $piece . '%')->get();
				foreach ($sites as $site) {
					$series = DB::table('series')->select('variablecode')->where('sitecode', '=', $site->sitecode)->get();
					foreach ($series as $s) {
						$sitecode = $site->sitecode;
						$variablecode = $s->variablecode;
						$url = url('/sites/' . $site->sitecode. '/' . $s->variablecode . '/update');
						$schedule->exec("wget -O/dev/null $url")->cron('0,20,40 * * * *');
					}
				}
			}
		}
		catch(\Exception $ex) {
			// Ignore all exceptions... this will catch if 'php artisan migration' hasn't been done yet
		}
		
		
		// :10 :30 :50 Ping the update URLs for cameras 
		$url = url('/cameras/update');
		$schedule->exec("wget -O/dev/null $url")->cron('10,30,50 * * * *');
	    
    }
}

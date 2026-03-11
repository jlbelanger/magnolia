<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class CacheClearExpired extends Command
{
	protected $signature = 'cache:clear-expired';

	protected $description = 'Clear expired rows from the database';

	public function handle()
	{
		$rows = DB::table('cache')->where('expiration', '<=', Carbon::now()->unix());
		$this->info('Deleting ' . $rows->count() . ' row(s)...');
		$rows->delete();
	}
}

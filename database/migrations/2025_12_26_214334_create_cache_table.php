<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Runs the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('cache', function (Blueprint $table) {
			$table->string('key')->primary();
			$table->mediumText('value');
			$table->integer('expiration')->index();
		});

		Schema::create('cache_locks', function (Blueprint $table) {
			$table->string('key')->primary();
			$table->string('owner');
			$table->integer('expiration')->index();
		});
	}

	/**
	 * Reverses the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('cache');
		Schema::dropIfExists('cache_locks');
	}
};

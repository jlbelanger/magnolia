<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSourcesToRecipesTable extends Migration
{
	/**
	 * Runs the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('recipes', function (Blueprint $table) {
			$table->text('sources')->nullable()->after('summary');
		});
	}

	/**
	 * Reverses the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('recipes', function (Blueprint $table) {
			$table->dropColumn('sources');
		});
	}
}

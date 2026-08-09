<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up() : void
	{
		Schema::table('recipes', function (Blueprint $table) {
			$table->text('sources')->nullable()->after('summary');
		});
	}

	public function down() : void
	{
		Schema::table('recipes', function (Blueprint $table) {
			$table->dropColumn('sources');
		});
	}
};

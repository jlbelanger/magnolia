<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
	/**
	 * Runs the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recipes', function (Blueprint $table) {
			$table->id();
			$table->string('title')->unique();
			$table->string('slug')->unique();
			$table->string('filename')->nullable();
			$table->text('summary')->nullable();
			$table->text('content');
			$table->text('notes')->nullable();
			$table->boolean('is_private')->default(true);
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Reverses the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('recipes');
	}
}

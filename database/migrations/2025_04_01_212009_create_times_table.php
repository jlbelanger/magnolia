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
	public function up() : void
	{
		Schema::create('times', function (Blueprint $table) {
			$table->id();
			$table->foreignId('recipe_id')->constrained()->onDelete('cascade');
			$table->string('title');
			$table->tinyInteger('minutes');
			$table->boolean('is_active')->default(false);
			$table->integer('order_num')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverses the migrations.
	 *
	 * @return void
	 */
	public function down() : void
	{
		Schema::dropIfExists('times');
	}
};

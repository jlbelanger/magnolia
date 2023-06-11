<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
	/**
	 * Runs the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('slug');
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});

		Schema::table('recipes', function (Blueprint $table) {
			$table->unsignedBigInteger('category_id')->nullable()->after('slug');
		});

		$category = Category::firstOrCreate(['title' => 'Other', 'slug' => 'other']);
		DB::table('recipes')->whereNull('category_id')->update(['category_id' => $category->getKey()]);

		Schema::table('recipes', function (Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')->constrained()->onDelete('restrict');
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
			$table->dropColumn('category_id');
		});

		Schema::dropIfExists('categories');
	}
}

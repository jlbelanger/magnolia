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
			$table->foreignId('category_id')->after('slug');
		});

		Category::firstOrCreate(['title' => 'Other', 'slug' => 'other']);
		DB::table('recipes')->where('category_id', '=', 0)->update(['category_id' => 1]);

		DB::statement('alter table `recipes` add constraint `recipes_category_id_foreign` foreign key (`category_id`) references `categories` (`id`) on delete restrict');
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

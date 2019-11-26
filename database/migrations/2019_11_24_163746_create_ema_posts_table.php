<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->integer('user_id');
			$table->integer('edited_by')->nullable();
			$table->string('title')->nullable();
			$table->string('excerpt', 140)->nullable();
			$table->text('content')->nullable();
			$table->string('image')->nullable();
			$table->string('video')->nullable();
			$table->string('post_created_at')->nullable();
			$table->string('slug')->nullable();
			$table->string('approved', 3)->default('yes');
			$table->integer('draft')->default(0);
			$table->integer('view_counter')->default(5);
			$table->dateTime('postponed_to')->nullable()->default('0000-00-00 00:00:00');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ema_posts');
	}

}

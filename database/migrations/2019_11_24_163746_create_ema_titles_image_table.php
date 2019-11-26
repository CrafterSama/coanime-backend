<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaTitlesImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('titles_image', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('title_id')->unique('serie_id');
			$table->string('name');
			$table->string('thumbnail');
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
		Schema::drop('ema_titles_image');
	}

}

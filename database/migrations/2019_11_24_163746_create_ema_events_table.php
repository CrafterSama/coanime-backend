<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('user_id', 11);
			$table->string('name');
			$table->string('slug');
			$table->string('image');
			$table->string('address');
			$table->integer('city_id');
			$table->char('country_code', 3);
			$table->dateTime('date_start')->nullable();
			$table->dateTime('date_end')->nullable();
			$table->text('description', 16777215);
			$table->integer('public_time')->nullable();
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
		Schema::drop('ema_events');
	}

}

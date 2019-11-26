<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaPeopleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('people', function(Blueprint $table)
		{
			$table->boolean('id')->primary();
			$table->string('name');
			$table->string('first_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();
			$table->string('japanese_name', 50);
			$table->string('slug');
			$table->date('birthday')->nullable();
			$table->string('falldown', 50)->default('no');
			$table->date('falldown_date')->nullable();
			$table->integer('city_id');
			$table->char('country_code', 3);
			$table->string('areas_skills_hobbies');
			$table->string('image')->nullable();
			$table->text('bio');
			$table->string('user_id', 11);
			$table->string('approved_info', 50)->default('si');
			$table->string('public_time')->nullable();
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
		Schema::drop('ema_people');
	}

}

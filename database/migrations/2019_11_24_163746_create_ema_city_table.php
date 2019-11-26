<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('city', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->char('name', 35)->default('');
			$table->char('country_code', 3)->default('')->index('country_code');
			$table->char('district', 20)->default('');
			$table->integer('population')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ema_city');
	}

}

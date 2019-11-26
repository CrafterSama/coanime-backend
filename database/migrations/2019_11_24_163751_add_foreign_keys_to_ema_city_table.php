<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEmaCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('city', function(Blueprint $table)
		{
			$table->foreign('country_code', 'ema_city_ibfk_1')->references('code')->on('ema_country')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('city', function(Blueprint $table)
		{
			$table->dropForeign('ema_city_ibfk_1');
		});
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaCountrylanguageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('countrylanguage', function(Blueprint $table)
		{
			$table->char('country_code', 3)->default('')->index('country_code');
			$table->char('language', 30)->default('');
			$table->string('is_official')->default('F');
			$table->float('percentage', 4, 1)->default(0.0);
			$table->primary(['country_code','language']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ema_countrylanguage');
	}

}

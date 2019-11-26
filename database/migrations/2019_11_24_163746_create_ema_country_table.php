<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaCountryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('country', function(Blueprint $table)
		{
			$table->char('code', 3)->default('')->primary();
			$table->char('name', 52)->default('');
			$table->string('continent')->default('Asia');
			$table->char('region', 26)->default('');
			$table->float('surface_area', 10)->default(0.00);
			$table->smallInteger('indep_year')->nullable();
			$table->integer('population')->default(0);
			$table->float('life_expectancy', 3, 1)->nullable();
			$table->float('gnp', 10)->nullable();
			$table->float('gnp_old', 10)->nullable();
			$table->char('local_name', 45)->default('');
			$table->char('government_form', 45)->default('');
			$table->char('head_of_state', 60)->nullable();
			$table->integer('capital')->nullable();
			$table->char('code2', 2)->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ema_country');
	}

}

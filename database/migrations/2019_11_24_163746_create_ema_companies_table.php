<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name')->unique('estudio_name');
			$table->string('slug');
			$table->string('website');
			$table->char('country_code', 3);
			$table->date('foundation_date')->default('0000-00-00');
			$table->string('public_time', 11)->nullable();
			$table->string('user_id', 11);
			$table->text('about', 16777215);
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
		Schema::drop('ema_companies');
	}

}

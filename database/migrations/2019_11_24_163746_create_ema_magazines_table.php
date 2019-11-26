<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaMagazinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('magazines', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 60);
			$table->string('slug');
			$table->string('website');
			$table->string('public_time', 11)->nullable();
			$table->string('user_id', 11);
			$table->timestamp('foundation_date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->text('about', 16777215);
			$table->char('country_code', 3)->default('JPN');
			$table->integer('release_id');
			$table->integer('type_id');
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
		Schema::drop('ema_magazines');
	}

}

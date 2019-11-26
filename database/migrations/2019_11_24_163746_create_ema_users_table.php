<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmaUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nick')->nullable()->index('nick');
			$table->string('email')->index('email');
			$table->string('password');
			$table->string('image')->nullable();
			$table->string('name');
			$table->text('bio')->nullable();
			$table->integer('genre')->default(0);
			$table->dateTime('birthday')->nullable();
			$table->string('slug')->index('slug');
			$table->string('twitter')->nullable();
			$table->string('facebook')->nullable();
			$table->string('instagram')->nullable();
			$table->string('devianart')->nullable();
			$table->string('tumblr')->nullable();
			$table->string('behance')->nullable();
			$table->string('googleplus')->nullable();
			$table->string('pinterest')->nullable();
			$table->string('website')->nullable();
			$table->integer('role_id')->default(2);
			$table->string('remember_token', 100)->nullable();
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
		Schema::drop('ema_users');
	}

}

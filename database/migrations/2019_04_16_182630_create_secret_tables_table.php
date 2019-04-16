<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecretTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		//Create new table for holding secrets
		Schema::create('secret_tables', function (Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('hash', 256);
			$table->mediumText('secretText');
			$table->string('createdAt');
			$table->string('expiresAt');
			$table->integer('remainingViews');
			$table->integer('expireAfterViews');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secret_tables');
    }
}

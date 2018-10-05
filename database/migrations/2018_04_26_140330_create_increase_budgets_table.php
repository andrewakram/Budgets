<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncreaseBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('increase_budgets', function (Blueprint $table) {
            $table->increments('increase_b_id');
            $table->string('i_b_name');
            $table->double('i_b_amount', 8, 2);
            $table->integer('budget_id');
            $table->enum('i_b_flag', ['true', 'false']);
            $table->string('api_token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('increase_budgets');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_creditor', function (Blueprint $table) {
            $table->unsignedBigInteger('loan_id');
            $table->unsignedBigInteger('creditor_id');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->foreign('creditor_id')->references('id')->on('creditors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_creditor');
    }
};

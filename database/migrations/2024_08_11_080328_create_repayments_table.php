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
        Schema::create('repayments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('loan_id');
            $table->date('payment_date');
            $table->decimal('payment_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repayments', function (Blueprint $table) {
            // 先删除外键约束
            $table->dropForeign(['loan_id']);
        });

        Schema::dropIfExists('repayments'); // 删除 repayments 表
    }
};

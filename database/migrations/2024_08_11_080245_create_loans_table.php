<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('debtor_detail_id')->nullable(); // Ensure this matches the debtor_details table
            $table->date('loan_date');
            $table->string('debtor_name');
            $table->decimal('loan_amount', 10, 2);
            $table->integer('installments')->nullable();
            $table->decimal('interest_rate', 5, 2);
            $table->string('repayment_method')->nullable();
            $table->decimal('monthly_payment_amount', 10, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('debtor_detail_id')
                ->references('id')
                ->on('debtor_details')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['debtor_detail_id']);
            $table->dropColumn('debtor_detail_id');
        });

        Schema::dropIfExists('loans');
    }
};
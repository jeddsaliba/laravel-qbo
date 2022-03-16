<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQboPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qbo_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('foreign key from your payments table.');
            $table->unsignedBigInteger('qbo_id')->comment('Unique identifier for this object. Sort order is ASC by default.');
            $table->unsignedBigInteger('qbo_invoice_id')->nullable();
            $table->unsignedBigInteger('qbo_customer_id')->nullable();
            $table->decimal('qbo_paid_amount', 10, 2)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qbo_invoices');
    }
}
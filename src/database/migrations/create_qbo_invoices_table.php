<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQboInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qbo_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reference_id');
            $table->unsignedBigInteger('qbo_id');
            $table->text('qbo_invoice_no');
            $table->text('qbo_invoice_link')->nullable();
            $table->decimal('qbo_total_amount', 10, 2)->default(0);
            $table->decimal('qbo_paid_amount', 10, 2)->default(0);
            $table->decimal('qbo_balance_amount', 10, 2)->default(0);
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
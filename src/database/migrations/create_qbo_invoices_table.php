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
            $table->unsignedBigInteger('reference_id')->nullable()
                ->comment('foreign key from your invoice table.');
            $table->unsignedBigInteger('qbo_id')
                ->comment('Unique identifier for this object. Sort order is ASC by default.');
            $table->unsignedBigInteger('qbo_customer_id');
            $table->string('qbo_invoice_no', 21);
            $table->enum('qbo_print_status', ['NotSet', 'NeedToPrint', 'PrintComplete'])->default('NotSet');
            $table->date('qbo_due_date');
            $table->enum('qbo_email_status', ['NotSet', 'NeedToSend', 'EmailSent'])->default('NotSet');
            $table->text('qbo_invoice_link')->nullable();
            $table->decimal('qbo_total_amount', 10, 2)->default(0);
            $table->decimal('qbo_paid_amount', 10, 2)->default(0);
            $table->decimal('qbo_balance_amount', 10, 2)->default(0);
            $table->enum('qbo_payment_status', ['Not Yet Sent', 'Sent', 'Partially Paid', 'Deposited'])->default('Not Yet Sent');
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
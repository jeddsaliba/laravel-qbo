<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQboCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qbo_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reference_id')->nullable()
                ->comment('foreign key from your user/customer table.');
            $table->unsignedBigInteger('qbo_id')
                ->comment('Unique identifier for this object. Sort order is ASC by default.');
            $table->text('qbo_display_name')
                ->comment('The name of the person or organization as displayed. Must be unique across all Customer, Vendor, and Employee objects. Cannot be removed with sparse update. If not supplied, the system generates DisplayName by concatenating customer name components supplied in the request from the following list: Title, GivenName, MiddleName, FamilyName, and Suffix.');
            $table->string('qbo_title', 15)->nullable()
                ->comment('Title of the person. This tag supports i18n, all locales. The DisplayName attribute or at least one of Title, GivenName, MiddleName, FamilyName, or Suffix attributes is required.');
            $table->string('qbo_given_name', 100)
                ->comment('Given name or first name of a person. The DisplayName attribute or at least one of Title, GivenName, MiddleName, FamilyName, or Suffix attributes is required.');
            $table->string('qbo_middle_name', 100)->nullable()
                ->comment('Middle name of the person. The person can have zero or more middle names. The DisplayName attribute or at least one of Title, GivenName, MiddleName, FamilyName, or Suffix attributes is required.');
            $table->string('qbo_suffix', 16)->nullable()
                ->comment('Suffix of the name. For example, Jr. The DisplayName attribute or at least one of Title, GivenName, MiddleName, FamilyName, or Suffix attributes is required.');
            $table->string('qbo_family_name', 100)
                ->comment('Family name or the last name of the person. The DisplayName attribute or at least one of Title, GivenName, MiddleName, FamilyName, or Suffix attributes is required.');
            $table->string('qbo_mobile_no', 30)->nullable()
                ->comment('Mobile phone number.');
            $table->string('qbo_phone_no', 30)->nullable()
                ->comment('Primary phone number.');
            $table->string('qbo_email_address', 100)->nullable()
                ->comment('Primary email address. The address format must follow the RFC 822 standard.');
            $table->text('qbo_notes')->nullable()
                ->comment('Free form text describing the Customer.');
            $table->text('qbo_website')->nullable()
                ->comment('Website address.');
            $table->boolean('qbo_active')->default(true)
                ->comment('If true, this entity is currently enabled for use by QuickBooks. If there is an amount in Customer.Balance when setting this Customer object to inactive through the QuickBooks UI, a CreditMemo balancing transaction is created for the amount.');
            $table->string('qbo_company_name', 100)->nullable()
                ->comment('The name of the company associated with the person or organization.');
            $table->decimal('qbo_balance', 10, 2)->default(0)
                ->comment('Specifies the open balance amount or the amount unpaid by the customer. For the create operation, this represents the opening balance for the customer. When returned in response to the query request it represents the current open balance (unpaid amount) for that customer. Write-on-create.');
            $table->boolean('qbo_is_project')->default(false)
                ->comment('If true, indicates this is a Project.');
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
        Schema::dropIfExists('qbo_customers');
    }
}
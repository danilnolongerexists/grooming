<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
public function up()
{
Schema::create('transactions', function (Blueprint $table) {
$table->id();
$table->string('type'); // income или expense
$table->decimal('amount', 10, 2);
$table->text('description')->nullable();
$table->dateTime('date');
$table->timestamps();
});
}

public function down()
{
Schema::dropIfExists('transactions');
}
}
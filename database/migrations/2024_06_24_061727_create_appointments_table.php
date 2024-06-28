<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
public function up()
{
Schema::create('appointments', function (Blueprint $table) {
$table->id();
$table->foreignId('client_id')->constrained()->onDelete('cascade');
$table->foreignId('groomer_id')->constrained('users')->onDelete('cascade');
$table->foreignId('service_id')->constrained()->onDelete('cascade');
$table->dateTime('appointment_time');
$table->string('status')->nullable();
$table->timestamps();
});
}

public function down()
{
Schema::dropIfExists('appointments');
}
}
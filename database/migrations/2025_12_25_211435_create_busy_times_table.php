<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('busy_times', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('organization_id');
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');
        $table->string('reason')->nullable();
        $table->timestamps();

        $table->foreign('organization_id')
              ->references('id')
              ->on('organizations')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('busy_times');
    }
};

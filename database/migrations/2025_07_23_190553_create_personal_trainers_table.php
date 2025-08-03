<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('personal_trainers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('photo')->nullable();
        $table->text('specialties');
        $table->string('contact_info');
        $table->timestamps();
    });
}
};

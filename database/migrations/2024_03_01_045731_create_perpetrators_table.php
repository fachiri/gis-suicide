<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpetrators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->unsignedInteger('age');
            $table->string('education');
            $table->string('address');
            $table->string('marital_status');
            $table->string('occupation');
            $table->date('incident_date');
            $table->string('suicide_method');
            $table->string('suicide_tool');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpetrators');
    }
};

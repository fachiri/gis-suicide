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
            $table->uuid();
            $table->string('name');
            $table->foreignId('gender')->constrained('criterias')->onDelete('cascade');
            $table->unsignedInteger('age');
            $table->foreignId('age_class')->constrained('criterias')->onDelete('cascade');
            $table->foreignId('education')->constrained('criterias')->onDelete('cascade');
            $table->string('address');
            $table->foreignId('marital_status')->constrained('criterias')->onDelete('cascade');
            $table->foreignId('occupation')->constrained('criterias')->onDelete('cascade');
            $table->date('incident_date');
            $table->string('suicide_method');
            $table->string('suicide_tool');
            $table->foreignId('motive')->constrained('criterias')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->string('district_code');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpetrators');
    }
};

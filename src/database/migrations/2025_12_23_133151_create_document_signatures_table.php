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
        Schema::create('document_signatures', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger("file_id")->nullable();

            $table->string("title");
            $table->string("person")->nullable();
            $table->string("position")->nullable();
            $table->string("organization")->nullable();
            $table->date("date")->nullable();
            $table->string("certificate")->nullable();
            $table->text("issued")->nullable();
            $table->string("period")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_signatures');
    }
};

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

            $table->string("title")->comment("Заголовок");
            $table->string("person")->nullable()->comment("Подписант");
            $table->string("position")->nullable()->comment("Должность");
            $table->string("organization")->nullable()->comment("Организация");
            $table->date("date")->nullable()->comment("Дата подписания");
            $table->string("certificate")->nullable()->comment("Сертификат");
            $table->text("issued")->nullable()->comment("Кем выдан");
            $table->string("period")->nullable()->comment("Период действия сертификата");

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

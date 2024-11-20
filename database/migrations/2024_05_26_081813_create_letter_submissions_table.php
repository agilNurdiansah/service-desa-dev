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
        Schema::create('letter_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('letter');
            $table->string('type_letter');
            $table->string('id_user_maker');
            $table->string('name_user_maker');
            $table->string('status');
            $table->string('type_maker');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_submissions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_files', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->unsignedBigInteger('user_id');

            // Grade 10
            $table->string('file10Front');
            $table->string('file10Back');

            // Grade 11
            $table->string('file11Front');
            $table->string('file11'); // Back

            // Grade 12
            $table->string('file12Front');
            $table->string('file12'); // Back

            // Others
            $table->string('fileId');          // School ID
            $table->string('fileNonEnroll');   // Certificate of Non-Enrollment
            $table->string('filePSA');         // PSA Birth Cert
            $table->string('fileGoodMoral');   // Good Moral Certificate
            $table->string('fileUnderOath');   // Under Oath
            $table->string('filePhoto2x2');    // 2x2 Photo

            $table->timestamps();

            // FK constraint
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_files');
    }
};

<?php
declare(strict_types=1);

namespace Test\Database\migrations;

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
        Schema::create('links', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('userId');

            $table->unsignedBigInteger('resourceType');
            $table->json('resources')->nullable();

            $table->string('shortUrl', 16);
            $table->string('longUrl', 4096);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};

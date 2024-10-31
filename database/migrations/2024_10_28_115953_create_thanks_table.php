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
        Schema::create('thanks', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("user");
            $table->uuid("offer")->nullable();
            $table->foreign("user")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("offer")->references("id")->on("offers")->onDelete("set null");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanks');
    }
};

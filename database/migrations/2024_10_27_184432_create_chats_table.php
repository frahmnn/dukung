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
        Schema::create("chats", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("from");
            $table->uuid("chatroom");
            $table->text("message");
            $table->foreign("from")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("chatroom")->references("id")->on("chatrooms")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};

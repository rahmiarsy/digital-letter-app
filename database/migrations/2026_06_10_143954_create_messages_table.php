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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // The ID of the user who sends the message (links to users table)
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            // The username of the person receiving the message
            $table->string('receiver_username'); 
            // The actual text content
            $table->text('message_body');
            $table->timestamps(); // Creates created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
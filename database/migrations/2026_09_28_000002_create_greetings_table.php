<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('greetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('friend_id')->constrained()->cascadeOnDelete();
            $table->text('message');
            $table->string('channel', 20)->default('inapp'); // inapp|whatsapp|email
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['friend_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('greetings');
    }
};

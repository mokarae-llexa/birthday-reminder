<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('birthday_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('friend_id')->constrained()->cascadeOnDelete();
            $table->string('type', 20)->default('upcoming'); // today|tomorrow|upcoming|greeting
            $table->string('title');
            $table->text('message');
            $table->date('notify_date');
            $table->timestamp('read_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'friend_id', 'type', 'notify_date'], 'birthday_notif_unique');
            $table->index(['user_id', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('birthday_notifications');
    }
};

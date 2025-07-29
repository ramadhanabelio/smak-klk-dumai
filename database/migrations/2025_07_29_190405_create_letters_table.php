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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();

            $table->string('letter_number')->unique()->nullable();
            $table->string('regarding')->nullable();
            $table->string('attachment')->nullable();

            $table->foreignId('type_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('division_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('sender_name')->nullable();
            $table->date('date_of_letter')->nullable();
            $table->date('date_of_entry')->nullable();
            $table->text('note')->nullable();

            $table->enum('status', ['incoming', 'outgoing', 'booking']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};

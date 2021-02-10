<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseDumpTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('invoice_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')
                ->constrained('locations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date')->nullable();
            $table->enum('status', ['draft','open','processed']);
            $table->timestamps();
        });

        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_header_id')
                ->constrained('invoice_headers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('description');
            $table->decimal('value', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists('invoice_headers');
        Schema::dropIfExists('invoice_lines');
    }
}

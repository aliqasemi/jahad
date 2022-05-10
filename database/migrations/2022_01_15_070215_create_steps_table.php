<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('send_sms')->default(false);
            $table->integer('sort')->default(1);
            $table->foreignId('service_template_id')->nullable()->references('id')->on('templates')->nullOnDelete();
            $table->foreignId('requirement_template_id')->nullable()->references('id')->on('templates')->nullOnDelete();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->index('service_template_id');
            $table->index('requirement_template_id');
            $table->index('project_id');
            $table->index('user_id');
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
        Schema::dropIfExists('steps');
    }
}

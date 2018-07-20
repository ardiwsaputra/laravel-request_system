<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('request_no');
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('description');
            $table->text('feedback');
            $table->text('file');
            $table->enum('status', ['open', 'in progress', '3rd party', 'closed', 'cancel']);
            $table->timestamps();

            //foreign key
            $table->integer('department_id')
                ->index() // index
                ->unsigned();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade')
                ->onUpdate('cascade')
            ;

            $table->integer('service_id')
                ->index() // index
                ->unsigned();
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade')
                ->onUpdate('cascade')
            ;

            $table->integer('user_id')
                ->index() // index
                ->unsigned()
                ->nullable()
            ;
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade')
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reqs');
    }
}

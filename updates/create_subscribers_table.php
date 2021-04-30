<?php namespace Indikator\Newsletter\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateSubscribersTable extends Migration
{
    public function up()
    {
        Schema::create('indikator_newsletter_subscribers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->text('comment')->nullable();
            $table->string('created', 1)->default(1);
            $table->string('status', 1)->default(1);
            $table->integer('statistics')->default(0);
            $table->dateTime('registered_at')->nullable();
            $table->string('registered_ip')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->string('confirmed_ip')->nullable();
            $table->string('confirmation_hash')->nullable();
            $table->dateTime('unsubscribed_at')->nullable();
            $table->string('unsubscribed_ip')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('indikator_newsletter_subscribers');
    }
}

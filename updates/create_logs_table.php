<?php namespace Indikator\Newsletter\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateLogsTable extends Migration
{
    public function up()
    {
        Schema::create('indikator_newsletter_logs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('mail_id')->nullable()->unsigned();
            $table->integer('subscriber_id')->nullable()->unsigned();
            $table->string('status', 191);
            $table->string('job_id', 32)->nullable();
            $table->string('hash', 191)->nullable();
            $table->dateTime('queued_at');
            $table->dateTime('send_at')->nullable();
            $table->dateTime('viewed_at')->nullable();
            $table->dateTime('clicked_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('indikator_newsletter_logs');
    }
}

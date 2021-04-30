<?php namespace Indikator\Newsletter\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateMailsTable extends Migration
{
    public function up()
    {
        Schema::create('indikator_newsletter_mails', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title', 100);
            $table->longText('content')->nullable();
            $table->string('status', 1)->default(1);
            $table->timestamp('published_at')->nullable();
            $table->dateTime('last_send_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('indikator_newsletter_mails');
    }
}

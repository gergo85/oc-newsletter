<?php namespace Indikator\Newsletter\Updates;

use October\Rain\Database\Updates\Migration;
use DbDongle;

class UpdateTimestampsNullable extends Migration
{
    public function up()
    {
        DbDongle::disableStrictMode();

        DbDongle::convertTimestamps('indikator_newsletter_mails');
        DbDongle::convertTimestamps('indikator_newsletter_subscribers');
    }

    public function down()
    {
        // ...
    }
}

<?php namespace Indikator\Newsletter\Models;

use Backend\Models\ExportModel;

class MailsExport extends ExportModel
{
    public $table = 'indikator_newsletter_mails';

    public function exportData($columns, $sessionKey = null)
    {
        return self::make()->get()->toArray();
    }
}

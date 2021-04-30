<?php namespace Indikator\Newsletter\Models;

use Backend\Models\ExportModel;

class SubscribersExport extends ExportModel
{
    public $table = 'indikator_newsletter_subscribers';

    public function exportData($columns, $sessionKey = null)
    {
        return self::make()->get()->toArray();
    }
}

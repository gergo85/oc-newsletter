<?php namespace Indikator\Newsletter\FormWidgets;

use Backend\Classes\FormField;
use Backend\Classes\FormWidgetBase;
use Request;
use Indikator\Newsletter\Models\Mails;

class MailInfo extends FormWidgetBase
{
    protected $defaultAlias = 'mailinfo';

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('mailinfo');
    }

    protected function prepareVars()
    {
        $uriList  = explode('/', Request::path());
        $newsInfo = Mails::whereId(end($uriList))->first();

        $this->vars['statistics'] = $newsInfo->statistics;
        $this->vars['updated_at'] = substr($newsInfo->updated_at, 0, -3);
    }

    public function getSaveValue($value)
    {
        return \Backend\Classes\FormField::NO_SAVE_DATA;
    }
}

<?php namespace Indikator\Newsletter\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Indikator\Newsletter\Models\Mails as Mail;

class NewMails extends ReportWidgetBase
{
    public function render()
    {
        try {
            $this->loadData();
        }
        catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('widget');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'title'             => 'backend::lang.dashboard.widget_title_label',
                'default'           => 'indikator.newsletter::lang.widget.newmails',
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error'
            ],
            'piece' => [
                'title'   => 'indikator.newsletter::lang.widget.show_piece',
                'default' => 5,
                'type'    => 'dropdown',
                'options' => [3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12]
            ],
            'date' => [
                'title'   => 'indikator.newsletter::lang.widget.show_date',
                'default' => true,
                'type'    => 'checkbox'
            ],
            'rank' => [
                'title'   => 'indikator.newsletter::lang.widget.show_rank',
                'default' => false,
                'type'    => 'checkbox'
            ]
        ];
    }

    protected function loadData()
    {
        $this->vars['mails'] = Mail::where('status', 1)->orderBy('created_at', 'desc')->take($this->property('piece'))->get()->all();
    }
}

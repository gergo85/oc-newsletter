<?php namespace Indikator\Newsletter\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Indikator\Newsletter\Models\Mails as Mail;

class Mails extends ReportWidgetBase
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
                'default'           => 'indikator.newsletter::lang.widget.mails',
                'type'              => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error'
            ],
            'total' => [
                'title'   => 'indikator.newsletter::lang.widget.show_total',
                'default' => true,
                'type'    => 'checkbox'
            ],
            'final' => [
                'title'   => 'indikator.newsletter::lang.widget.show_active',
                'default' => true,
                'type'    => 'checkbox'
            ],
            'draft' => [
                'title'   => 'indikator.newsletter::lang.widget.show_draft',
                'default' => true,
                'type'    => 'checkbox'
            ]
        ];
    }

    protected function loadData()
    {
        $this->vars['final'] = Mail::where('status', 1)->count();
        $this->vars['draft'] = Mail::where('status', 2)->count();
        $this->vars['total'] = $this->vars['final'] + $this->vars['draft'];
    }
}

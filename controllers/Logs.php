<?php namespace Indikator\Newsletter\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Logs extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class
    ];

    public $requiredPermissions = ['indikator.newsletter.logs'];

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Indikator.Newsletter', 'newsletter', 'logs');
    }
}

<?php namespace Indikator\Newsletter\Models;

use Model;

class Settings extends Model
{
    public $implement = ['@System.Behaviors.SettingsModel'];

    public $settingsCode = 'indikator_newsletter_settings';

    public $settingsFields = 'fields.yaml';
}

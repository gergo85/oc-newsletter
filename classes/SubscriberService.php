<?php namespace Indikator\Newsletter\Classes;

use Indikator\Newsletter\Models\Categories;
use Indikator\Newsletter\Models\Settings;
use Db;

trait SubscriberService
{
    /**
     * Handles subscriber registration
     * either by registration in the frontend or by creating in the backend
     * 
     * @param $subscriber
     * @param $listOfCategoryIds array of subscribing ids
     * @return void
     */
    public function onSubscriberRegister($subscriber, $listOfCategoryIds)
    {
        // Register category
        if (is_array($listOfCategoryIds)) {
            foreach ($listOfCategoryIds as $category) {
                if (is_numeric($category) && Categories::where(['id' => $category, 'hidden' => 2])->count() == 1 && Db::table('indikator_newsletter_relations')->where(['subscriber_id' => $subscriber->id, 'categories_id' => $category])->count() == 0) {
                    Db::table('indikator_newsletter_relations')->insert([
                        'subscriber_id' => $subscriber->id,
                        'categories_id' => $category
                    ]);
                }
            }
        }

        if (!$subscriber->isActive()) {
            if (Settings::get('newsletter_double_opt_in', true)) {
                $subscriber->register();
                ConfirmationHandler::sendConfirmationEmailToSubscriber($subscriber);
            }
            else {
                $subscriber->activate();
            }
        }
    }
}

<?php

//Dateien Bezeichnung
namespace HaraRenameImages\Subscriber;

//nutzen Klasse SubscriberInterface
use Enlight\Event\SubscriberInterface;

//Klasse Cronjob erstellt und implementiert das SubscriberInterface als Interface
/**Das Interface gibt vor welche Methoden implementiert werden müssen
 *ohne die Implementierung zu definieren 
 *Anmerkung: Methoden müssen ihren Inhalt nicht definierem Und sie müssen public sein!
 */
class Cronjob implements SubscriberInterface
{
    /**
     *getSubscribedEvents-Methode für Subscriber
     *@return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'Shopware_CronJob_HaraRenameImages' => 'onCronjobExecute'
        );
    }

    /**
     * listener-Methode für cronjob-subscriber
     * 
     * @param Shopware_Components_Cron_CronJob $job
     */
    //Eine Listener Funktion wird aufgerufen wenn ein best. Event ausgelöst wird
    //Hier wenn Cronjob executes dann auch onCronJobExecute() 
    //Hier wird später das Umbennen der Bilder stattfinden 
    public function onCronJobExecute(\Shopware_Components_Cron_CronJob $job)
    { }
}

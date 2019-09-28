<?php
//Der Pluginname, welcher Probleme verhindern soll falls andere Entwickler 
//den gleichen Namen nutzen!!
namespace HaraRenameImages;


use Doctrine\ORM\Tools\SchemaTool;
use HaraRenameImages\Models\RenamedImage;
use Shopware\Components\Model\ModelManager;
//Hier benutzen wir die Shopware-Klasse "Plugin"
use Shopware\Components\Plugin;
//InstallContext Klasse wird benuzt als Param in den Methoden unten
use Shopware\Components\Plugin\Context\InstallContext;
//UninstallContext Klasse wird benuzt als Param in den Methoden unten
use Shopware\Components\Plugin\Context\UninstallContext;

//Klasse mit Pluginname welche von der Klasse Plugin erbt!
class HaraRenameImages extends Plugin
{

    /**
     * @param InstallContext $context
     *
     */
    public function install(InstallContext $context)
    {
        //holen Service(Ansammlung versch. Funktionen) über Service-Container
        //Hier DBAL-Service dieser holt Daten aus DB oder fügt welche ein
        $connection = $this->container->get('dbal_connection');

        //hinzufügen des cronjob. -> bedeutet:Aufruf einer Methode in einer Instanz oder
        //Zugriff auf einer Instanz Eigenschaft
        //insert Funktion wandelt Parameter in eine Query und schickt diese der DB
        $connection->insert(
            //Unsere DB bzw Tabelle in der wir einen Eintrag einfügen
            's_crontab',
            [
                'name'             => 'Bilder umbenennen',
                'action'           => 'Shopware_CronJob_HaraRenameImages',
                'next'             => new \DateTime(),
                'start'            => null,
                '`interval`'       => '86400',
                'active'           => 1,
                'end'              => new \DateTime(),
                'pluginID'         => null
            ],
            [
                'next' => 'datetime',
                'end' => 'datetime',
            ]
        );

        //Die Model-Klasse
        $modelManager = $this->container->get('models');

        //Model hinzufügen
        $tool = new SchemaToll($modelManager);

        $classMetaData = [
            $modelManager->getClassMetadata(RenamedImage::class)
        ];
        //hinzufügen findet hier statt mit createSchema
        $tool->createSchema($classMetaData);
    }

    /**
     * @param UninstallContext $context
     *
     */
    public function uninstall(UninstallContext $context)
    {
        //dbal_connection Verbindung mit Shopware Datenbank
        $connection = $this->container->get('dbal_connection');

        //cronjob entfernen
        $this->container->get('dbal_connection')->executeQuery('DELETE FROM s_crontab WHERE `action` = ?', [
            'Shopware_CronJob_HaraRenameImages'
        ]);

        $modelManager = $this->container->get('models');

        //Model entfernen
        $tool = new SchemaTool($modelManager);

        $classMetaData = [
            $modelManager->getClassMetadata(RenamedImage::class)
        ];
        //Das entfernen finden hier statt mit dropSchema
        $tool->dropSchema($classMetaData);
    }
}

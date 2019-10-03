<?php

namespace saltyUpdateCurrencyRates;

use Shopware\Components\Plugin;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Shopware\Models\Widget\Widget;

/**
 * Shopware-Plugin saltyUpdateCurrencyRates.
 */
class saltyUpdateCurrencyRates extends Plugin
{
    /**
     * Adds the widget to the database and creates the database schema.
     *
     * @param Plugin\Context\InstallContext $installContext
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function install(Plugin\Context\InstallContext $installContext)
    {
        parent::install($installContext);

        $em = $this->container->get('models');

        //setup schema
        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $classes = [$em->getClassMetadata(\saltyUpdateCurrencyRates\Models\RateLog::class)];

        if(!$em->getConnection()->getSchemaManager()->tablesExist(array('salty_rates_log'))) {
            $tool->createSchema($classes);
        }


        //setup widget
        $repo = $em->getRepository(\Shopware\Models\Plugin\Plugin::class);
        /** @var \Shopware\Models\Plugin\Plugin $plugin */
        $plugin = $repo->findOneBy([ 'name' => 'saltyUpdateCurrencyRates' ]);

        $widget = new Widget();
        $widget->setName('salty_update_currency_rates');
        $widget->setPlugin($plugin);

        $plugin->getWidgets()->add($widget);
    }

    /**
     * Remove widget and remove database schema.
     *
     * @param Plugin\Context\UninstallContext $uninstallContext
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function uninstall(Plugin\Context\UninstallContext $uninstallContext)
    {
        parent::uninstall($uninstallContext);
        $modelManager = $this->container->get('models');
        $repo = $modelManager->getRepository(Widget::class);

        $widget = $repo->findOneBy([ 'name' => 'salty_update_currency_rates' ]);
        $modelManager->remove($widget);
        $modelManager->flush();

    }

    /**
    * @param ContainerBuilder $container
    */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('salty_update_currency_rates.plugin_dir', $this->getPath());
        parent::build($container);
    }

}

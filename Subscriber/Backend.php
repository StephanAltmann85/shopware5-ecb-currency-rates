<?php

namespace saltyUpdateCurrencyRates\Subscriber;

use Enlight\Event\SubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Backend implements SubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
    * @return array
    */
    public static function getSubscribedEvents()
    {
        return array(
            'Enlight_Controller_Action_PostDispatch_Backend_Index' => 'extendsBackendWidget',
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_saltyUpdateCurrencyRatesWidget' => 'getBackendWidgetController',
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_saltyUpdateCurrencyRates' => 'getBackendController'
        );
    }

    public function extendsBackendWidget(\Enlight_Event_EventArgs $args)
    {
        /** @var \Enlight_Controller_Action $controller */
        $controller = $args->getSubject();

        if ($controller->Request()->getActionName() !== 'index') {
            return;
        }

        $dir = $this->container->getParameter('salty_update_currency_rates.plugin_dir');
        $controller->View()->addTemplateDir($dir . '/Resources/views/');
        $controller->View()->extendsTemplate('backend/widgets/salty_update_currency_rates.js');
    }

    /**
    * Register the backend widget controller
    *
    * @param   \Enlight_Event_EventArgs $args
    * @return  string
    */
    public function getBackendWidgetController(\Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Backend/saltyUpdateCurrencyRatesWidget.php';
    }

    /**
    * Register the backend widget controller
    *
    * @param   \Enlight_Event_EventArgs $args
    * @return  string
    */
    public function getBackendController(\Enlight_Event_EventArgs $args)
    {
        return __DIR__ . '/../Controllers/Backend/saltyUpdateCurrencyRates.php';
    }
}

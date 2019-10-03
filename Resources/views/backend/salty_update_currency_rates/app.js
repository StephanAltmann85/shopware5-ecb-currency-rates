Ext.define('Shopware.apps.saltyUpdateCurrencyRates', {

    extend: 'Enlight.app.SubApplication',

    /**
     * The name of the module. Used for internal purpose
     * @string
     */
    name:'Shopware.apps.saltyUpdateCurrencyRates',


    launch: function() {
        var me = this;


        Ext.Ajax.request({
            url: '{url controller=saltyUpdateCurrencyRates action=update}',
            success: function() {
                Shopware.Notification.createGrowlMessage(
                    '{s namespace="backend/salty" name="update_title"}{/s}',
                    '{s namespace="backend/salty" name="update_success"}{/s}',
                    'UpdateCurrencyRates'
                );

            }
        });

    }
});





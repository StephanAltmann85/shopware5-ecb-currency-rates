
//{block name="backend/index/application" append}
Ext.define('Shopware.apps.saltyUpdateCurrencyRates.widgets.saltyUpdateCurrencyRates', {
    extend: 'Shopware.apps.Index.view.widgets.Base',

    alias: 'widget.salty_update_currency_rates',

    layout: 'fit',

    initComponent: function () {
        var me = this;

        me.items = me.getItems();

        me.callParent(arguments);
    },

    getItems: function () {
        var me = this;

        return [
            {
                xtype: 'grid',
                store: me.getWidgetStore(),
                viewConfig: {
                    hideLoadingMsg: true
                },
                border: 0,
                hideHeaders: true,
                columns: [
                    {
                        dataIndex: 'currency',
                        flex: 1
                    },
                    {
                        dataIndex: 'factor',
                        flex: 1
                    },
                    {
                        dataIndex: '1',
                        flex: 1,
                        renderer: function(value) {
                            if(!value) {
                                return '';
                            }

                            value = Math.round(value * 100) / 100;

                            if(value > 0) {
                                return '<span style="color: #41df44;">' + value + '%</span>';
                            }
                            else if(value < 0) {
                                return '<span style="color: #ff0000;">' + value + '%</span>';
                            }
                            else {
                                return value;
                            }
                        }
                    },
                    {
                        dataIndex: 'updated',
                        header: '',
                        renderer:Ext.util.Format.dateRenderer('d.m. H:i'),
                        flex: 1
                    }
                ]
            }
        ];
    },

    getWidgetStore: function () {
        var me = this;

        return Ext.create('Ext.data.Store', {
            fields: [
                { name: 'currency', type: 'string' },
                { name: 'factor', type: 'float' },
                { name: '1', type: 'float' },
                { name: 'updated', type: 'datetime' }
            ],
            proxy: {
                type: 'ajax',
                url: '{url controller=saltyUpdateCurrencyRatesWidget action=loadBackendWidget}',
                reader: {
                    type: 'json',
                    root: 'data'
                }
            },
            autoLoad: true
        });
    }



});
//{/block}
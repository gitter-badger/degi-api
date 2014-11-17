/*
 * File: app/view/OrderGridPanelViewModel.js
 *
 * This file was generated by Sencha Architect version 3.1.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 5.0.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 5.0.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('Target.view.OrderGridPanelViewModel', {
    extend: 'Ext.app.ViewModel',
    alias: 'viewmodel.ordergridpanel',

    requires: [
        'Ext.data.Store',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],

    stores: {
        OrderStore: {
            autoLoad: true,
            autoSync: true,
            model: 'Target.model.OrderModel',
            proxy: {
                type: 'ajax',
                url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/order',
                reader: {
                    type: 'json',
                    rootProperty: 'rows'
                }
            }
        }
    }

});
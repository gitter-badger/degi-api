/*
 * File: app/view/ifSubWindowViewModel.js
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

Ext.define('Target.view.ifSubWindowViewModel', {
    extend: 'Ext.app.ViewModel',
    alias: 'viewmodel.ifsubwindow',

    requires: [
        'Ext.data.Store',
        'Ext.data.field.Field'
    ],

    stores: {
        ItemStatusStore: {
            data: [
                {
                    if_status: '1',
                    if_status_name: '上架'
                },
                {
                    if_status: '2',
                    if_status_name: '下架'
                }
            ],
            fields: [
                {
                    name: 'if_status'
                },
                {
                    name: 'if_status_name'
                }
            ]
        }
    }

});
/*
 * File: app/view/MemberGridPanelViewModel.js
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

Ext.define('Target.view.MemberGridPanelViewModel', {
    extend: 'Ext.app.ViewModel',
    alias: 'viewmodel.membergridpanel',

    requires: [
        'Ext.data.Store',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json',
        'Ext.data.field.Field'
    ],

    stores: {
        MemberStore: {
            autoLoad: true,
            autoSync: true,
            model: 'Target.model.MemberModel',
            proxy: {
                type: 'ajax',
                url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/member',
                reader: {
                    type: 'json',
                    rootProperty: 'rows'
                }
            }
        },
        MemberStatusStore: {
            data: [
                {
                    mm_status: 1,
                    text: '啟用'
                },
                {
                    mm_status: 2,
                    text: '停用'
                }
            ],
            fields: [
                {
                    name: 'mm_status'
                },
                {
                    name: 'text'
                }
            ]
        }
    }

});
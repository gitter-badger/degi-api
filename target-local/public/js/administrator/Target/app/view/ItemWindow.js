/*
 * File: app/view/ItemWindow.js
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

Ext.define('Target.view.ItemWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.itemwindow',

    requires: [
        'Target.view.ItemWindowViewModel',
        'Ext.form.Panel',
        'Ext.form.field.ComboBox',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button',
        'Ext.form.field.Hidden'
    ],

    viewModel: {
        type: 'itemwindow'
    },
    height: 313,
    id: 'itemwindow',
    width: 528,
    title: 'My Window',
    defaultListenerScope: true,

    items: [
        {
            xtype: 'form',
            id: 'iForm',
            bodyPadding: 10,
            title: '',
            items: [
                {
                    xtype: 'textfield',
                    anchor: '100%',
                    fieldLabel: '名稱',
                    name: 'im_name',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    anchor: '100%',
                    height: 100,
                    fieldLabel: '描述',
                    name: 'im_description',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    anchor: '100%',
                    fieldLabel: '規格',
                    name: 'im_spec',
                    allowBlank: false
                },
                {
                    xtype: 'combobox',
                    anchor: '100%',
                    fieldLabel: '配送方式',
                    name: 'im_delivery_method',
                    allowBlank: false,
                    editable: false,
                    displayField: 'im_delivery_name',
                    valueField: 'im_delivery_method',
                    bind: {
                        store: '{ItemDeliveryStore}'
                    }
                },
                {
                    xtype: 'combobox',
                    anchor: '100%',
                    fieldLabel: '狀態',
                    name: 'im_status',
                    allowBlank: false,
                    editable: false,
                    displayField: 'im_status_name',
                    valueField: 'im_status',
                    bind: {
                        store: '{ItemStatusStore}'
                    }
                }
            ]
        },
        {
            xtype: 'hiddenfield',
            id: 'im_id',
            name: 'im_id'
        }
    ],
    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'bottom',
            layout: {
                type: 'hbox',
                pack: 'end'
            },
            items: [
                {
                    xtype: 'button',
                    id: 'iAddBtn',
                    width: 509,
                    text: '新增',
                    listeners: {
                        click: 'onIAddBtnClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'iUpdateBtn',
                    width: 509,
                    text: '修改',
                    listeners: {
                        click: 'onIUpdateBtnClick'
                    }
                }
            ]
        }
    ],

    onIAddBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('iForm').getForm();

        if(form.isValid()){
            form.submit({
                waitTitle:'訊息',
                waitMsg:'新增資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_main',

                success:function(form,action){

                    var store  = Ext.getCmp('itemgridpanel').getViewModel().getStore('ItemStore');
                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/item_main';
                    store.load();
                    var window = Ext.getCmp('itemwindow');
                    window.close();
                    Ext.Msg.alert('訊息','商品新增成功');

                },
                failure:function(form,action){
                    data = Ext.decode(action.response.responseText);
                    if (data.success === false && data.msg){
                        Ext.Msg.alert('Error', data.msg);
                    }
                }
            });
        }
    },

    onIUpdateBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('iForm').getForm();

        if(form.isValid()){
           form.submit({
               method: 'PUT',
               waitTitle:'訊息',
               waitMsg:'修改資料中',
               url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_main',

               success:function(form,action){

                   var store  = Ext.getCmp('itemgridpanel').getViewModel().getStore('ItemStore');
                   store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/item_main';
                   store.load();
                   var window = Ext.getCmp('itemwindow');
                   window.close();
                   Ext.Msg.alert('訊息','商品修改成功');

               },
               failure:function(form,action){
                   data = Ext.decode(action.response.responseText);
                   if (data.success === false && data.msg){
                       Ext.Msg.alert('Error', data.msg);
                   }
               }
           });
        }
    }

});
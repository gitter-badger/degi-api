/*
 * File: app/view/storewindow.js
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

Ext.define('Target.view.storewindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.storewindow',

    requires: [
        'Target.view.StoreWindowViewModel',
        'Ext.form.Panel',
        'Ext.form.field.TextArea',
        'Ext.form.field.File',
        'Ext.form.field.Number',
        'Ext.form.field.Hidden',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button'
    ],

    viewModel: {
        type: 'storewindow'
    },
    height: 434,
    id: 'storewindow',
    width: 608,
    modal: true,
    defaultListenerScope: true,

    items: [
        {
            xtype: 'form',
            height: 354,
            id: 'storeForm',
            width: 690,
            bodyPadding: '20 0 0 30 ',
            items: [
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 598,
                    fieldLabel: '顯示名稱',
                    name: 'sl_name',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 598,
                    fieldLabel: '電話',
                    name: 'sl_tel_no',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 598,
                    fieldLabel: '傳真',
                    name: 'sl_fax_no',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 598,
                    fieldLabel: '信箱',
                    name: 'sl_email',
                    allowBlank: false
                },
                {
                    xtype: 'textareafield',
                    anchor: '80%',
                    width: 598,
                    fieldLabel: '地址',
                    name: 'sl_address',
                    allowBlank: false
                },
                {
                    xtype: 'textareafield',
                    anchor: '80%',
                    fieldLabel: 'GoogleMap地址',
                    name: 'sl_googlemaps_address',
                    allowBlank: false
                },
                {
                    xtype: 'filefield',
                    id: 'sl_cover',
                    width: 527,
                    fieldLabel: '店面縮圖',
                    name: 'sl_cover',
                    allowBlank: false,
                    buttonText: 'Browse'
                },
                {
                    xtype: 'numberfield',
                    anchor: '80%',
                    fieldLabel: '顯示排序',
                    name: 'sl_seq',
                    allowBlank: false,
                    minValue: 1
                },
                {
                    xtype: 'hiddenfield',
                    id: 'sl_id',
                    name: 'sl_id'
                }
            ]
        }
    ],
    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'bottom',
            height: 41,
            layout: {
                type: 'hbox',
                pack: 'end'
            },
            items: [
                {
                    xtype: 'button',
                    id: 'storeAddBtn',
                    width: 589,
                    text: '新增',
                    listeners: {
                        click: 'onStoreAddBtnClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'storeUpdateBtn',
                    width: 589,
                    text: '修改',
                    listeners: {
                        click: 'onStoreUpdateBtnClick'
                    }
                }
            ]
        }
    ],

    onStoreAddBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('storeForm').getForm();

        if(form.isValid()){
            form.submit({
                method: 'POST',
                waitTitle:'訊息',
                waitMsg:'新增資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/store',

                success:function(form,action){

                    var store  = Ext.getCmp('storegridpanel').getViewModel().getStore('StoreStore');
                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/store';
                    store.load();
                    var window = Ext.getCmp('storewindow');
                    window.close();
                    //form.reset();
                    Ext.Msg.alert('訊息','店面資訊新增成功');

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

    onStoreUpdateBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('storeForm').getForm();

        if(form.isValid()){
            form.submit({
                method: 'POST',
                waitTitle:'訊息',
                waitMsg:'修改資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/store',
                success: function(form,action){
                   var store  = Ext.getCmp('storegridpanel').getViewModel().getStore('StoreStore');
                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/store';
                    store.load();
                    //form.reset();

                    Ext.Msg.alert('訊息','店面資訊修改成功', function(){
                        var window = Ext.getCmp('storewindow');
                        window.close();
                    });
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
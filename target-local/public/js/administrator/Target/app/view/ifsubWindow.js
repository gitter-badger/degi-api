/*
 * File: app/view/ifsubWindow.js
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

Ext.define('Target.view.ifsubWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.ifsubwindow',

    requires: [
        'Target.view.ifSubWindowViewModel',
        'Ext.form.Panel',
        'Ext.form.field.Hidden',
        'Ext.form.field.File',
        'Ext.form.field.Number',
        'Ext.form.field.ComboBox',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button'
    ],

    viewModel: {
        type: 'ifsubwindow'
    },
    height: 220,
    id: 'ifsubWindow',
    width: 431,
    modal: true,
    defaultListenerScope: true,

    items: [
        {
            xtype: 'form',
            id: 'ifSubForm',
            bodyPadding: '20 0 0 0 ',
            items: [
                {
                    xtype: 'hiddenfield',
                    id: 'im_id_ifsub',
                    name: 'im_id'
                },
                {
                    xtype: 'textfield',
                    anchor: '90%',
                    fieldLabel: '口味名稱',
                    labelAlign: 'right',
                    name: 'if_name',
                    allowBlank: false
                },
                {
                    xtype: 'textfield',
                    anchor: '90%',
                    fieldLabel: '單價',
                    labelAlign: 'right',
                    name: 'if_unit_price',
                    allowBlank: false
                },
                {
                    xtype: 'filefield',
                    anchor: '90%',
                    id: 'if_cover',
                    width: 429,
                    fieldLabel: '圖片',
                    labelAlign: 'right',
                    name: 'if_cover',
                    allowBlank: false,
                    buttonText: 'Browse'
                },
                {
                    xtype: 'numberfield',
                    anchor: '90%',
                    fieldLabel: '排序',
                    labelAlign: 'right',
                    name: 'if_seq',
                    allowBlank: false,
                    minValue: 1
                },
                {
                    xtype: 'combobox',
                    anchor: '100%',
                    fieldLabel: '狀態',
                    name: 'if_status',
                    allowBlank: false,
                    editable: false,
                    displayField: 'if_status_name',
                    valueField: 'if_status',
                    bind: {
                        store: '{ItemStatusStore}'
                    }
                },
                {
                    xtype: 'hiddenfield',
                    id: 'if_id',
                    name: 'if_id'
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
                    id: 'ifsubAddBtn',
                    width: 412,
                    text: '新增',
                    listeners: {
                        click: 'onCMPAddBtnClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'ifsubUpdateBtn',
                    width: 413,
                    text: '修改',
                    listeners: {
                        click: 'onCMPUpdateBtnClick'
                    }
                }
            ]
        }
    ],

    onCMPAddBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('ifSubForm').getForm();
        var imId = Ext.getCmp('im_id_if').getValue();

        if(form.isValid()){
            form.submit({

                waitTitle:'訊息',
                waitMsg:'新增資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_flavor',

                success:function(form,action){

                    Ext.Ajax.request({

                        url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_flavor?im_id='+imId,
                        success: function(response, opts){

                            var obj = Ext.JSON.decode(response.responseText);
                            var store = Ext.getCmp('ifpanel').getStore();

                            if(obj.rows){
                                store.removeAll();
                                var cmp = Ext.JSON.decode(obj.rows);
                                console.log(cmp);

                                for( var i=0; i<(cmp.length); i++){
                                    store.add({
                                        if_id: cmp[i].if_id,
                                        im_id: cmp[i].im_id,
                                        im_name: cmp[i].im_name,
                                        if_name: cmp[i].if_name,
                                        if_cover: cmp[i].if_cover,
                                        if_unit_price: cmp[i].if_unit_price,
                                        if_seq: cmp[i].if_seq,
                                        if_status: cmp[i].if_status
                                    });
                                }
                            }else{
                                store.removeAll();
                            }
                        },
                        failure: function(response, opts){
                            console.log('server-side failure with status code ' + response.status);
                        }
                    });
                    var window = Ext.getCmp('ifsubWindow');
                    window.close();
                    Ext.Msg.alert('訊息','新增口味成功');

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

    onCMPUpdateBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('ifSubForm').getForm();
        var imId = Ext.getCmp('im_id_ifsub').getValue();
        var ifId = Ext.getCmp('if_id').getValue();


        if(form.isValid()){
            form.submit({
                method: 'POST',
                waitTitle:'訊息',
                waitMsg:'修改資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_flavor',

                success:function(form,action){

                    Ext.Ajax.request({

                        url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_flavor?im_id='+imId,
                        success: function(response, opts){

                            var obj = Ext.JSON.decode(response.responseText);
                            var store = Ext.getCmp('ifpanel').getStore();
                            if(obj.rows){
                                store.removeAll();
                                var cmp = Ext.JSON.decode(obj.rows);
                                console.log(cmp);

                                for( var i=0; i<(cmp.length); i++){
                                    store.add({
                                        if_id: cmp[i].if_id,
                                        im_id: cmp[i].im_id,
                                        im_name: cmp[i].im_name,
                                        if_name: cmp[i].if_name,
                                        if_cover: cmp[i].if_cover,
                                        if_unit_price: cmp[i].if_unit_price,
                                        if_seq: cmp[i].if_seq,
                                        if_status: cmp[i].if_status
                                    });
                                }
                            }else{
                                store.removeAll();
                            }
                        },
                        failure: function(response, opts){
                            console.log('server-side failure with status code ' + response.status);
                        }
                    });

                    var window = Ext.getCmp('ifsubWindow');
                    window.close();
                    Ext.Msg.alert('訊息','修改口味成功');

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
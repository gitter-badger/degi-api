/*
 * File: app/view/icrsubWindow.js
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

Ext.define('Target.view.icrsubWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.icrsubwindow',

    requires: [
        'Target.view.icrSubWindowViewModel',
        'Ext.form.field.Hidden',
        'Ext.form.Panel',
        'Ext.form.field.ComboBox',
        'Ext.form.field.Number',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button'
    ],

    viewModel: {
        type: 'icrsubwindow'
    },
    height: 161,
    id: 'icrsubWindow',
    width: 431,
    modal: true,
    defaultListenerScope: true,

    items: [
        {
            xtype: 'hiddenfield',
            id: 'icr_id_rel',
            name: 'icr_id'
        },
        {
            xtype: 'form',
            id: 'icrSubForm',
            bodyPadding: '20 0 0 0 ',
            items: [
                {
                    xtype: 'combobox',
                    anchor: '80%',
                    width: 343,
                    fieldLabel: '商品',
                    labelAlign: 'right',
                    name: 'im_id',
                    allowBlank: false,
                    editable: false,
                    displayField: 'im_name',
                    queryMode: 'local',
                    valueField: 'im_id',
                    bind: {
                        store: '{ItemMainStore}'
                    }
                },
                {
                    xtype: 'numberfield',
                    anchor: '80%',
                    fieldLabel: '排序',
                    labelAlign: 'right',
                    name: 'icr_seq'
                },
                {
                    xtype: 'hiddenfield',
                    id: 'ic_id_relsub',
                    name: 'ic_id'
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
                    id: 'icrsubAddBtn',
                    width: 412,
                    text: '新增',
                    listeners: {
                        click: 'onCMPAddBtnClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'icrsubUpdateBtn',
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
        var form = Ext.getCmp('icrSubForm').getForm();
        var icId = Ext.getCmp('ic_id_rel').getValue();

        if(form.isValid()){
            form.submit({

                waitTitle:'訊息',
                waitMsg:'新增資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category_relate',

                success:function(form,action){

                    Ext.Ajax.request({

                        url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category_relate?ic_id='+icId,
                        success: function(response, opts){

                            var obj = Ext.JSON.decode(response.responseText);
                            var store = Ext.getCmp('icrpanel').getStore();

                            if(obj.rows){
                                store.removeAll();
                                var cmp = Ext.JSON.decode(obj.rows);
                                console.log(cmp);

                                for( var i=0; i<(cmp.length); i++){
                                    store.add({
                                        ic_id: cmp[i].ic_id,
                                        im_id: cmp[i].im_id,
                                        im_name: cmp[i].im_name,
                                        icr_id: cmp[i].icr_id,
                                        icr_seq: cmp[i].icr_seq,
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
                    // store.proxy.url='http://git.localhost/degi-api/target-local/public/b/company_member_point?cm_id='+cmID;
                    // store.load();
                    var window = Ext.getCmp('icrsubWindow');
                    window.close();
                    //form.reset();
                    Ext.Msg.alert('訊息','商品種類新增商品成功');

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
        var form = Ext.getCmp('icrSubForm').getForm();
        var icId = Ext.getCmp('ic_id_relsub').getValue();
        var icrId = Ext.getCmp('icr_id_rel').getValue();


        if(form.isValid()){
            form.submit({
                method: 'PUT',
                waitTitle:'訊息',
                waitMsg:'修改資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category_relate/'+icrId,

                success:function(form,action){

                    Ext.Ajax.request({

                        url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category_relate?ic_id='+icId,
                        success: function(response, opts){

                            var obj = Ext.JSON.decode(response.responseText);
                            var store = Ext.getCmp('icrpanel').getStore();

                            if(obj.rows){
                                store.removeAll();
                                var cmp = Ext.JSON.decode(obj.rows);
                                console.log(cmp);

                                for( var i=0; i<(cmp.length); i++){
                                    store.add({
                                        ic_id: cmp[i].ic_id,
                                        im_id: cmp[i].im_id,
                                        im_name: cmp[i].im_name,
                                        icr_id: cmp[i].icr_id,
                                        icr_seq: cmp[i].icr_seq,
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
                    // store.proxy.url='http://git.localhost/degi-api/target-local/public/b/company_member_point?cm_id='+cmID;
                    // store.load();
                    var window = Ext.getCmp('icrsubWindow');
                    window.close();
                    //form.reset();
                    Ext.Msg.alert('訊息','商品種類修改商品成功');

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
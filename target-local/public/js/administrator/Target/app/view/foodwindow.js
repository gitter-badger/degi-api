/*
 * File: app/view/foodwindow.js
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

Ext.define('Target.view.foodwindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.foodwindow',

    requires: [
        'Target.view.FoodWindowViewModel',
        'Ext.form.Panel',
        'Ext.form.field.File',
        'Ext.form.field.Number',
        'Ext.form.field.Hidden',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button'
    ],

    viewModel: {
        type: 'foodwindow'
    },
    height: 200,
    id: 'foodwindow',
    width: 531,
    modal: true,
    defaultListenerScope: true,

    items: [
        {
            xtype: 'form',
            height: 134,
            id: 'foodForm',
            width: 592,
            bodyPadding: '20 0 0 0 ',
            items: [
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 356,
                    fieldLabel: '顯示標題',
                    labelAlign: 'right',
                    name: 'fc_name',
                    allowBlank: false
                },
                {
                    xtype: 'filefield',
                    id: 'fc_image',
                    width: 473,
                    fieldLabel: '認證圖檔',
                    labelAlign: 'right',
                    name: 'fc_image',
                    allowBlank: false,
                    buttonText: 'Browse'
                },
                {
                    xtype: 'numberfield',
                    anchor: '80%',
                    fieldLabel: '顯示排序',
                    labelAlign: 'right',
                    name: 'fc_seq',
                    allowBlank: false,
                    minValue: 1
                },
                {
                    xtype: 'hiddenfield',
                    id: 'fc_id',
                    name: 'fc_id'
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
                    id: 'foodAddBtn',
                    width: 513,
                    text: '新增',
                    listeners: {
                        click: 'onFoodAddBtnClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'foodUpdateBtn',
                    width: 513,
                    text: '修改',
                    listeners: {
                        click: 'onFoodUpdateBtnClick'
                    }
                }
            ]
        }
    ],

    onFoodAddBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('foodForm').getForm();

        if(form.isValid()){
            form.submit({
                method: 'POST',
                waitTitle:'訊息',
                waitMsg:'新增資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/food',

                success:function(form,action){

                    var store  = Ext.getCmp('foodgridpanel').getViewModel().getStore('FoodStore');
                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/food';
                    store.load();
                    var window = Ext.getCmp('foodwindow');
                    window.close();
                    //form.reset();
                    Ext.Msg.alert('訊息','食安認證新增成功');

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

    onFoodUpdateBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('foodForm').getForm();

        if(form.isValid()){
            form.submit({
                method: 'POST',
                waitTitle:'訊息',
                waitMsg:'修改資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/food',
                success: function(form,action){
                   var store  = Ext.getCmp('foodgridpanel').getViewModel().getStore('FoodStore');
                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/food';
                    store.load();
                    //form.reset();

                    Ext.Msg.alert('訊息','食安認證修改成功', function(){
                        var window = Ext.getCmp('foodwindow');
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
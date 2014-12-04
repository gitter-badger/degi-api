/*
 * File: app/view/ItemCategoryWindow.js
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

Ext.define('Target.view.ItemCategoryWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.itemcategorywindow',

    requires: [
        'Target.view.ItemCategoryWindowViewModel',
        'Ext.form.Panel',
        'Ext.form.field.ComboBox',
        'Ext.form.field.Number',
        'Ext.form.RadioGroup',
        'Ext.form.field.Radio',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button',
        'Ext.form.field.Hidden'
    ],

    viewModel: {
        type: 'itemcategorywindow'
    },
    height: 203,
    id: 'itemcategorywindow',
    width: 397,
    title: 'My Window',
    defaultListenerScope: true,

    items: [
        {
            xtype: 'form',
            id: 'icForm',
            bodyPadding: 10,
            title: '',
            items: [
                {
                    xtype: 'combobox',
                    anchor: '90%',
                    width: 271,
                    fieldLabel: '類型',
                    name: 'ic_type',
                    allowBlank: false,
                    editable: false,
                    displayField: 'pi_name',
                    valueField: 'pi_type',
                    bind: {
                        store: '{PopularStatusStore}'
                    }
                },
                {
                    xtype: 'textfield',
                    anchor: '90%',
                    width: 378,
                    fieldLabel: '名稱',
                    name: 'ic_name'
                },
                {
                    xtype: 'numberfield',
                    anchor: '90%',
                    fieldLabel: '排序',
                    name: 'ic_seq'
                },
                {
                    xtype: 'radiogroup',
                    fieldLabel: '狀態',
                    allowBlank: false,
                    layout: {
                        type: 'checkboxgroup',
                        autoFlex: false
                    },
                    items: [
                        {
                            xtype: 'radiofield',
                            id: 'ic_status_on',
                            name: 'ic_status',
                            boxLabel: '啟用',
                            inputValue: '1'
                        },
                        {
                            xtype: 'radiofield',
                            id: 'ic_status_off',
                            name: 'ic_status',
                            boxLabel: '停用',
                            inputValue: '2'
                        }
                    ]
                }
            ]
        },
        {
            xtype: 'hiddenfield',
            id: 'ic_id',
            fieldLabel: 'Label',
            name: 'ic_id'
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
                    id: 'icAddBtn',
                    width: 379,
                    text: '新增',
                    listeners: {
                        click: 'onButtonClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'icUpdateBtn',
                    width: 379,
                    text: '修改',
                    listeners: {
                        click: 'onButtonClick1'
                    }
                }
            ]
        }
    ],

    onButtonClick: function(button, e, eOpts) {
        var form = Ext.getCmp('icForm').getForm();

        if(form.isValid()){
            form.submit({
                waitTitle:'訊息',
                waitMsg:'新增資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category',

                success:function(form,action){

                    var store  = Ext.getCmp('itemcategorygridpanel').getViewModel().getStore('ItemCategoryStore');
                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category';
                    store.load();
                    var window = Ext.getCmp('itemcategorywindow');
                    window.close();
                    Ext.Msg.alert('訊息','商品分類新增成功');

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

    onButtonClick1: function(button, e, eOpts) {
        var form = Ext.getCmp('icForm').getForm();

        if(form.isValid()){
            var Id = Ext.getCmp('ic_id').getValue();

            var StatusOn = Ext.getCmp('ic_status_on').getValue();
            var StatusOff = Ext.getCmp('ic_status_off').getValue();
            var Status = 0;
            if(StatusOn === true && StatusOff === false){
                Status = 1;
            }else if(StatusOn === false && StatusOff === true){
                Status = 2;
            }else{
                Status = 2;
            }

            Ext.Ajax.request({
                method: 'PUT',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category/'+Id,
                params: {
                    ic_type: form.findField('ic_type').getValue(),
                    ic_name: form.findField('ic_name').getValue(),
                    ic_seq: form.findField('ic_seq').getValue(),
                    ic_status: Status
                },
                success: function(response, options){
                    var store  = Ext.getCmp('itemcategorygridpanel').getViewModel().getStore('ItemCategoryStore');
                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category';
                    store.load();

                    var window = Ext.getCmp('itemcategorywindow');
                    window.close();
                    Ext.Msg.alert('訊息','商品分類修改成功');
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
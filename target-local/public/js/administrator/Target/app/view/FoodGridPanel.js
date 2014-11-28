/*
 * File: app/view/FoodGridPanel.js
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

Ext.define('Target.view.FoodGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.foodgridpanel',

    requires: [
        'Target.view.FoodGridPanelViewModel',
        'Ext.button.Button',
        'Ext.grid.View',
        'Ext.grid.column.Column',
        'Ext.selection.CheckboxModel',
        'Ext.toolbar.Paging'
    ],

    viewModel: {
        type: 'foodgridpanel'
    },
    id: 'foodgridpanel',
    defaultListenerScope: true,

    bind: {
        store: '{FoodStore}'
    },
    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'button',
                    text: '新增',
                    listeners: {
                        click: 'onButtonClick'
                    }
                },
                {
                    xtype: 'button',
                    text: '修改',
                    listeners: {
                        click: 'onButtonClick1'
                    }
                },
                {
                    xtype: 'button',
                    text: '刪除',
                    listeners: {
                        click: 'onButtonClick11'
                    }
                }
            ]
        },
        {
            xtype: 'pagingtoolbar',
            dock: 'bottom',
            width: 360,
            displayInfo: true,
            bind: {
                store: '{FoodStore}'
            }
        }
    ],
    columns: [
        {
            xtype: 'gridcolumn',
            dataIndex: 'fc_name',
            text: '顯示標題',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                return (value !=='')?"<img src='images/food_certification_image/"+value+"' width='60px' />":'沒有任何圖片';

            },
            dataIndex: 'fc_image',
            text: '認證圖檔',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'fc_seq',
            text: '排序',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'fc_created',
            text: '建立時間',
            flex: 0.8
        }
    ],
    selModel: {
        selType: 'checkboxmodel'
    },

    onButtonClick: function(button, e, eOpts) {
        var window = Ext.create('Target.view.foodwindow');

        window.setConfig('title', '新增食安認證');

        Ext.getCmp('foodUpdateBtn').setVisible(false);
        Ext.getCmp('foodAddBtn').setVisible(true);

        window.show();
    },

    onButtonClick1: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('foodgridpanel').getSelectionModel();
        var count = selmodel.getCount();

        if(count !== 0){
            var seldata = selmodel.getSelection();

            var window = Ext.create('Target.view.foodwindow');

            Ext.getCmp('fc_id').setValue(seldata[0].data.fc_id);
            window.setConfig('title', '修改食安認證');

            Ext.getCmp('foodForm').getForm().setValues(seldata[0].data);

            Ext.getCmp('fc_image').allowBlank = true;
            Ext.getCmp('fc_image').emptyText = seldata[0].data.fc_image;
            Ext.getCmp('fc_image').applyEmptyText();

            Ext.getCmp('foodUpdateBtn').setVisible(true);
            Ext.getCmp('foodAddBtn').setVisible(false);

            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一個食安認證修改');
        }
    },

    onButtonClick11: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('foodgridpanel').getSelectionModel();
        var count = selmodel.getCount();
        if(count !== 0){
            Ext.MessageBox.confirm('Confirm', 'Are you sure to delete the data?', function(btn){
                if (btn == 'yes') {
                    var seldata = selmodel.getSelection();
                    var Id = seldata[0].data.fc_id;

                    Ext.Ajax.request({
                        method: 'DELETE',
                        url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/food/'+Id,

                        success: function(response, options){
                            var store  = Ext.getCmp('foodgridpanel').getViewModel().getStore('FoodStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/food';
                            store.load();

                            Ext.Msg.alert('訊息','食安認證刪除成功');
                        }
                    });
                }
            });
         }else{
            Ext.Msg.alert('訊息', '請選擇一個食安認證刪除');
        }

    }

});
/*
 * File: app/view/StoreGridPanel.js
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

Ext.define('Target.view.StoreGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.storegridpanel',

    requires: [
        'Target.view.StoreGridPanelViewModel',
        'Ext.button.Button',
        'Ext.grid.View',
        'Ext.grid.column.Column',
        'Ext.selection.CheckboxModel',
        'Ext.toolbar.Paging'
    ],

    viewModel: {
        type: 'storegridpanel'
    },
    id: 'storegridpanel',
    defaultListenerScope: true,

    bind: {
        store: '{StoreStore}'
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
                store: '{StoreStore}'
            }
        }
    ],
    columns: [
        {
            xtype: 'gridcolumn',
            dataIndex: 'sl_name',
            text: '顯示名稱',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'sl_googlemaps_address',
            text: 'Google Maps地址',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                return (value !=='')?"<img src='images/store_location_cover/"+value+"' width='60px' />":'沒有任何圖片';

            },
            dataIndex: 'sl_cover',
            text: '縮圖',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'sl_seq',
            text: '排序',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'sl_created',
            text: '建立時間',
            flex: 0.8
        }
    ],
    selModel: {
        selType: 'checkboxmodel'
    },

    onButtonClick: function(button, e, eOpts) {
        var window = Ext.create('Target.view.storewindow');

        window.setConfig('title', '新增店面資訊');

        Ext.getCmp('storeUpdateBtn').setVisible(false);
        Ext.getCmp('storeAddBtn').setVisible(true);

        window.show();
    },

    onButtonClick1: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('storegridpanel').getSelectionModel();
        var count = selmodel.getCount();

        if(count !== 0){
            var seldata = selmodel.getSelection();

            var window = Ext.create('Target.view.storewindow');

            Ext.getCmp('sl_id').setValue(seldata[0].data.sl_id);
            window.setConfig('title', '修改店面資訊');

            Ext.getCmp('storeForm').getForm().setValues(seldata[0].data);

            Ext.getCmp('sl_cover').allowBlank = true;
            Ext.getCmp('sl_cover').emptyText = seldata[0].data.sl_cover;
            Ext.getCmp('sl_cover').applyEmptyText();

            Ext.getCmp('storeUpdateBtn').setVisible(true);
            Ext.getCmp('storeAddBtn').setVisible(false);

            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一個店面資訊修改');
        }
    },

    onButtonClick11: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('storegridpanel').getSelectionModel();
        var count = selmodel.getCount();
        if(count !== 0){
            Ext.MessageBox.confirm('Confirm', 'Are you sure to delete the data?', function(btn){
                if (btn == 'yes') {
                    var seldata = selmodel.getSelection();
                    var Id = seldata[0].data.sl_id;

                    Ext.Ajax.request({
                        method: 'DELETE',
                        url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/store/'+Id,

                        success: function(response, options){
                            var store  = Ext.getCmp('storegridpanel').getViewModel().getStore('StoreStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/store';
                            store.load();

                            Ext.Msg.alert('訊息','店面資訊刪除成功');
                        }
                    });
                }
            });
         }else{
            Ext.Msg.alert('訊息', '請選擇一個店面資訊刪除');
        }

    }

});
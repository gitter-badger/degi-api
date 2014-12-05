/*
 * File: app/view/ItemGridPanel.js
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

Ext.define('Target.view.ItemGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.itemgridpanel',

    requires: [
        'Target.view.ItemGridPanelViewModel',
        'Ext.button.Button',
        'Ext.menu.Menu',
        'Ext.menu.Item',
        'Ext.grid.View',
        'Ext.grid.column.Column',
        'Ext.selection.CheckboxModel',
        'Ext.toolbar.Paging'
    ],

    viewModel: {
        type: 'itemgridpanel'
    },
    defaultListenerScope: true,
    id: 'itemgridpanel',

    bind: {
        store: '{ItemStore}'
    },
    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'button',
                    text: '功能',
                    menu: {
                        xtype: 'menu',
                        items: [
                            {
                                xtype: 'menuitem',
                                text: '新增',
                                listeners: {
                                    click: 'onMenuitemClick'
                                }
                            },
                            {
                                xtype: 'menuitem',
                                text: '修改',
                                listeners: {
                                    click: 'onMenuitemClick1'
                                }
                            },
                            {
                                xtype: 'menuitem',
                                text: '停用',
                                listeners: {
                                    click: 'onMenuitemClick2'
                                }
                            }
                        ]
                    }
                },
                {
                    xtype: 'button',
                    text: '口味管理',
                    listeners: {
                        click: 'onButtonClick'
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
                store: '{ItemStore}'
            }
        }
    ],
    columns: [
        {
            xtype: 'gridcolumn',
            dataIndex: 'im_name',
            text: '名稱',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'im_spec',
            text: '規格',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                if( value == 1 ){
                    return '宅配';
                }else{
                    return '常溫';
                }
            },
            dataIndex: 'im_delivery_method',
            text: '配送方式',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'im_box_number',
            text: '滿箱數',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                if( value == 1 ){
                    return '上架';
                }else if ( value == 2 ){
                    return '下架';
                }else{
                    return '未定義';
                }
            },
            dataIndex: 'im_status',
            text: '狀態',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'im_modified',
            text: '最後修改',
            flex: 1
        }
    ],
    selModel: {
        selType: 'checkboxmodel'
    },

    onMenuitemClick: function(item, e, eOpts) {
        var window = Ext.create('Target.view.ItemWindow');

        window.setConfig('title', '新增商品');

        Ext.getCmp('iUpdateBtn').setVisible(false);
        Ext.getCmp('iAddBtn').setVisible(true);

        window.show();
    },

    onMenuitemClick1: function(item, e, eOpts) {
        var selmodel = Ext.getCmp('itemgridpanel').getSelectionModel();
        var count = selmodel.getCount();

        if(count !== 0){
            var seldata = selmodel.getSelection();

            var window = Ext.create('Target.view.ItemWindow');

            Ext.getCmp('im_id').setValue(seldata[0].data.im_id);

            window.setConfig('title', '修改商品資料');

            Ext.getCmp('iForm').getForm().setValues(seldata[0].data);

            Ext.getCmp('iAddBtn').setVisible(false);
            Ext.getCmp('iUpdateBtn').setVisible(true);

            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一個商品修改');
        }
    },

    onMenuitemClick2: function(item, e, eOpts) {
        var selmodel = Ext.getCmp('itemgridpanel').getSelectionModel();
        var count = selmodel.getCount();
        if(count !== 0){
            Ext.MessageBox.confirm('Confirm', 'Are you sure to delete the data?', function(btn){
                if (btn == 'yes') {
                    var seldata = selmodel.getSelection();
                    var imId = seldata[0].data.im_id;

                    Ext.Ajax.request({
                        method: 'DELETE',
                        url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_main/'+imId,

                        success: function(response, options){
                            var store  = Ext.getCmp('itemgridpanel').getViewModel().getStore('ItemStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/item_main';
                            store.load();

                            Ext.Msg.alert('訊息','商品停用成功');
                        }
                    });
                }
            });
        }else{
            Ext.Msg.alert('訊息', '請選擇一個商品刪除');
        }
    },

    onButtonClick: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('itemgridpanel').getSelectionModel();
        var count = selmodel.getCount();
        var seldata = selmodel.getSelection();

        if(count !== 0 ){

            var window = Ext.create('Target.view.ifWindow');

            window.setConfig('title', seldata[0].data.im_name+' 口味管理');


            Ext.Ajax.request({

                url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_flavor?im_id='+seldata[0].data.im_id,
                success: function(response, opts){

                    var obj = Ext.JSON.decode(response.responseText);
                    var store = Ext.getCmp('ifpanel').getStore();

                    if(obj.rows){
                        store.removeAll();
                        var cmp = Ext.JSON.decode(obj.rows);
                       // console.log(cmp);

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
            Ext.getCmp('im_id_if').setValue(seldata[0].data.im_id);
            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一筆商品管理口味');
        }
    }

});
/*
 * File: app/view/ItemCategoryGridPanel.js
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

Ext.define('Target.view.ItemCategoryGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.itemcategorygridpanel',

    requires: [
        'Target.view.ItemCategoryGridPanelViewModel',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button',
        'Ext.menu.Menu',
        'Ext.menu.Item',
        'Ext.selection.CheckboxModel',
        'Ext.grid.View',
        'Ext.grid.column.Column'
    ],

    viewModel: {
        type: 'itemcategorygridpanel'
    },
    id: 'itemcategorygridpanel',
    title: 'My Grid Panel',
    defaultListenerScope: true,

    bind: {
        store: '{ItemCategoryStore}'
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
                    text: '商品選取',
                    listeners: {
                        click: 'onButtonClick'
                    }
                }
            ]
        }
    ],
    selModel: {
        selType: 'checkboxmodel'
    },
    viewConfig: {
        id: 'itemCategoryGrid'
    },
    columns: [
        {
            xtype: 'gridcolumn',
            dataIndex: 'ic_name',
            text: '名稱',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                if( value == 1 ){
                    return '宅配商品';
                }else if( value == 2 ){
                    return '店面商品';
                }else{
                    return '未定義';
                }
            },
            dataIndex: 'ic_type',
            text: '類型',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'ic_seq',
            text: '排序',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                if( value == 1 ){
                    return '上架';
                }else if( value == 2 ){
                    return '下架';
                }else{
                    return '未定義';
                }
            },
            dataIndex: 'ic_status',
            text: '狀態',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'ic_modified',
            text: '最後修改',
            flex: 1
        }
    ],

    onMenuitemClick: function(item, e, eOpts) {
        var window = Ext.create('Target.view.ItemCategoryWindow');

        window.setConfig('title', '新增商品種類');

        Ext.getCmp('icUpdateBtn').setVisible(false);
        Ext.getCmp('icAddBtn').setVisible(true);

        window.show();

    },

    onMenuitemClick1: function(item, e, eOpts) {
        var selmodel = Ext.getCmp('itemcategorygridpanel').getSelectionModel();
        var count = selmodel.getCount();

        if(count !== 0){
            var seldata = selmodel.getSelection();

            var window = Ext.create('Target.view.ItemCategoryWindow');

            Ext.getCmp('ic_id').setValue(seldata[0].data.ic_id);

            window.setConfig('title', '修改商品種類');

            Ext.getCmp('icForm').getForm().setValues(seldata[0].data);

            Ext.getCmp('icAddBtn').setVisible(false);
            Ext.getCmp('icUpdateBtn').setVisible(true);

            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一個商品種類修改');
        }
    },

    onMenuitemClick2: function(item, e, eOpts) {
        var selmodel = Ext.getCmp('itemcategorygridpanel').getSelectionModel();
        var count = selmodel.getCount();
        if(count !== 0){
            Ext.MessageBox.confirm('Confirm', 'Are you sure to delete the data?', function(btn){
                if (btn == 'yes') {
                    var seldata = selmodel.getSelection();
                    var icId = seldata[0].data.ic_id;

                    Ext.Ajax.request({
                        method: 'DELETE',
                        url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category/'+icId,

                        success: function(response, options){
                            var store  = Ext.getCmp('itemcategorygridpanel').getViewModel().getStore('ItemCategoryStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category';
                            store.load();

                            Ext.Msg.alert('訊息','商品種類停用成功');
                        }
                    });
                }
            });
        }else{
            Ext.Msg.alert('訊息', '請選擇一個商品種類刪除');
        }

    },

    onButtonClick: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('itemcategorygridpanel').getSelectionModel();
        var count = selmodel.getCount();
        var seldata = selmodel.getSelection();

        if(count !== 0 ){

            var window = Ext.create('Target.view.icrWindow');

            window.setConfig('title', '商品分類選取商品管理');


            Ext.Ajax.request({

                url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_category_relate?ic_id='+seldata[0].data.ic_id,
                success: function(response, opts){

                    var obj = Ext.JSON.decode(response.responseText);
                    var store = Ext.getCmp('icrpanel').getStore();

                    if(obj.rows){
                        store.removeAll();
                        var cmp = Ext.JSON.decode(obj.rows);
                        //console.log(cmp);

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
            Ext.getCmp('ic_id_rel').setValue(seldata[0].data.ic_id);
            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一筆商品分類管理關聯商品');
        }
    }

});
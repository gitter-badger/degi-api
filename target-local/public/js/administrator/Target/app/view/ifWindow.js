/*
 * File: app/view/ifWindow.js
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

Ext.define('Target.view.ifWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.ifwindow',

    requires: [
        'Target.view.ifWindowViewModel',
        'Ext.form.FieldContainer',
        'Ext.grid.Panel',
        'Ext.grid.column.Column',
        'Ext.selection.CheckboxModel',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button',
        'Ext.form.field.Hidden'
    ],

    viewModel: {
        type: 'ifwindow'
    },
    height: 491,
    id: 'ifWindow',
    width: 630,
    modal: true,
    defaultListenerScope: true,

    layout: {
        type: 'vbox',
        align: 'stretch'
    },
    items: [
        {
            xtype: 'fieldcontainer',
            flex: 1,
            width: 644,
            layout: {
                type: 'vbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'container',
                    flex: 1,
                    autoScroll: true,
                    layout: {
                        type: 'vbox',
                        align: 'stretch'
                    },
                    items: [
                        {
                            xtype: 'gridpanel',
                            id: 'ifpanel',
                            rowLines: false,
                            store: 'ifArrayStore',
                            columns: [
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'if_name',
                                    text: '口味名稱',
                                    flex: 1
                                },
                                {
                                    xtype: 'gridcolumn',
                                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                                        return (value !=='')?"<img src='images/item_flavor_cover/"+value+"' width='60px' />":'沒有任何圖片';

                                    },
                                    dataIndex: 'if_cover',
                                    text: '圖片',
                                    flex: 1
                                },
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'if_unit_price',
                                    text: '單價',
                                    flex: 0.5
                                },
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'if_seq',
                                    text: '排序',
                                    flex: 0.5
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
                                    dataIndex: 'if_status',
                                    text: '狀態',
                                    flex: 0.5
                                }
                            ],
                            selModel: {
                                selType: 'checkboxmodel'
                            }
                        }
                    ]
                }
            ]
        },
        {
            xtype: 'hiddenfield',
            flex: 1,
            id: 'im_id_if',
            name: 'im_id_if'
        }
    ],
    dockedItems: [
        {
            xtype: 'toolbar',
            flex: 1,
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
                    text: '下架',
                    listeners: {
                        click: 'onButtonClick2'
                    }
                }
            ]
        }
    ],

    onButtonClick: function(button, e, eOpts) {
        var window = Ext.create('Target.view.ifsubWindow');

        window.setConfig('title', '加入新口味');

        Ext.getCmp('ifsubUpdateBtn').setVisible(false);
        Ext.getCmp('ifsubAddBtn').setVisible(true);
        Ext.getCmp('im_id_ifsub').setValue(Ext.getCmp('im_id_if').getValue());

        window.show();
    },

    onButtonClick1: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('ifpanel').getSelectionModel();
        var count = selmodel.getCount();

        if(count !== 0){
            var seldata = selmodel.getSelection();

            var window = Ext.create('Target.view.ifsubWindow');

            Ext.getCmp('im_id_ifsub').setValue(seldata[0].data.im_id);
            Ext.getCmp('if_id').setValue(seldata[0].data.if_id);

            window.setConfig('title', '修改口味');

            Ext.getCmp('if_cover').allowBlank = true;
            Ext.getCmp('if_cover').emptyText = seldata[0].data.if_cover;
            Ext.getCmp('if_cover').applyEmptyText();

            Ext.getCmp('ifSubForm').getForm().setValues(seldata[0].data);

            Ext.getCmp('ifsubUpdateBtn').setVisible(true);
            Ext.getCmp('ifsubAddBtn').setVisible(false);

            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一個口味修改');
        }
    },

    onButtonClick2: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('ifpanel').getSelectionModel();
        var count = selmodel.getCount();
        if(count !== 0){
            Ext.MessageBox.confirm('Confirm', 'Are you sure to delete the data?', function(btn){
                if (btn == 'yes') {
                    var seldata = selmodel.getSelection();
                    var ifId = seldata[0].data.if_id;
                    var imId = seldata[0].data.im_id;

                    Ext.Ajax.request({
                        method: 'DELETE',
                        url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/item_flavor/'+ifId,

                        success: function(response, options){
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

                            Ext.Msg.alert('訊息','口味刪除成功');
                        }
                    });
                }
            });
        }else{
            Ext.Msg.alert('訊息', '請選擇一個口味刪除');
        }

    }

});
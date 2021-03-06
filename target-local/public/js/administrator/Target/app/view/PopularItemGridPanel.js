/*
 * File: app/view/PopularItemGridPanel.js
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

Ext.define('Target.view.PopularItemGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.popularitemgridpanel',

    requires: [
        'Target.view.PopularItemGridPanelViewModel',
        'Ext.button.Button',
        'Ext.grid.View',
        'Ext.grid.column.Column',
        'Ext.selection.CheckboxModel',
        'Ext.toolbar.Paging'
    ],

    viewModel: {
        type: 'popularitemgridpanel'
    },
    id: 'popularitemgridpanel',
    defaultListenerScope: true,

    bind: {
        store: '{PopularItemStore}'
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
                store: '{PopularItemStore}'
            }
        }
    ],
    columns: [
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                if( value == 1 ){
                    return '宅配熱銷';
                }else if( value == 2 ){
                    return '店面熱銷';
                }else{
                    return '未定義';
                }
            },
            dataIndex: 'pi_type',
            text: '類型',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'pi_title',
            text: '商品標題',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                return (value !=='')?"<img src='images/popular_item/"+value+"' width='60px' />":'沒有任何圖片';

            },
            dataIndex: 'pi_image',
            text: '商品大圖',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'pi_description',
            text: '商品描述',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'pi_seq',
            text: '在同類型下排序',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'pi_created',
            text: '建立時間',
            flex: 0.8
        }
    ],
    selModel: {
        selType: 'checkboxmodel'
    },

    onButtonClick: function(button, e, eOpts) {
        var window = Ext.create('Target.view.popularwindow');

        window.setConfig('title', '新增熱銷商品');

        Ext.getCmp('popularUpdateBtn').setVisible(false);
        Ext.getCmp('popularAddBtn').setVisible(true);

        window.show();
    },

    onButtonClick1: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('popularitemgridpanel').getSelectionModel();
        var count = selmodel.getCount();

        if(count !== 0){
            var seldata = selmodel.getSelection();

            var window = Ext.create('Target.view.popularwindow');

            Ext.getCmp('pi_id').setValue(seldata[0].data.pi_id);
            window.setConfig('title', '修改熱銷商品');

            Ext.getCmp('popularitemForm').getForm().setValues(seldata[0].data);

            Ext.getCmp('pi_image').allowBlank = true;
            Ext.getCmp('pi_image').emptyText = seldata[0].data.pi_image;
            Ext.getCmp('pi_image').applyEmptyText();

            Ext.getCmp('popularUpdateBtn').setVisible(true);
            Ext.getCmp('popularAddBtn').setVisible(false);

            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一個熱銷商品修改');
        }
    },

    onButtonClick11: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('popularitemgridpanel').getSelectionModel();
        var count = selmodel.getCount();
        if(count !== 0){
            Ext.MessageBox.confirm('Confirm', 'Are you sure to delete the data?', function(btn){
                if (btn == 'yes') {
                    var seldata = selmodel.getSelection();
                    var pId = seldata[0].data.pi_id;

                    Ext.Ajax.request({
                        method: 'DELETE',
                        url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/popular_item/'+pId,

                        success: function(response, options){
                            var store  = Ext.getCmp('popularitemgridpanel').getViewModel().getStore('PopularItemStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/popular_item';
                            store.load();

                            Ext.Msg.alert('訊息','熱銷商品刪除成功');
                        }
                    });
                }
            });
         }else{
            Ext.Msg.alert('訊息', '請選擇一個熱銷商品刪除');
        }

    }

});
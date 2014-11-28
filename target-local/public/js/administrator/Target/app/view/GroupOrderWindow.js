/*
 * File: app/view/GroupOrderWindow.js
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

Ext.define('Target.view.GroupOrderWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.grouporderwindow',

    requires: [
        'Target.view.GroupWindowViewModel',
        'Ext.form.FieldContainer',
        'Ext.grid.Panel',
        'Ext.grid.column.Column'
    ],

    viewModel: {
        type: 'grouporderwindow'
    },
    height: 543,
    id: 'GroupOrderWindow',
    width: 738,
    modal: true,

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
                            id: 'grouporderpanel',
                            rowLines: false,
                            store: 'GroupOrderArrayStore',
                            columns: [
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'id',
                                    text: '編號',
                                    flex: 0.5
                                },
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'name',
                                    text: '訂購人',
                                    flex: 1
                                },
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'im_name',
                                    text: '商品名稱',
                                    flex: 1
                                },
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'if_name',
                                    text: '口味',
                                    flex: 1
                                },
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'if_unit_price',
                                    text: '單價',
                                    flex: 1
                                },
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'if_count',
                                    text: '購買數量',
                                    flex: 1
                                },
                                {
                                    xtype: 'gridcolumn',
                                    dataIndex: 'if_subtotal',
                                    text: '小計',
                                    flex: 1
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]

});
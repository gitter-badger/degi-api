/*
 * File: app/view/CompanyMemberGridPanel.js
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

Ext.define('Target.view.CompanyMemberGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.companymembergridpanel',

    requires: [
        'Target.view.CompanyMemberGridPanelViewModel',
        'Ext.grid.View',
        'Ext.selection.CheckboxModel',
        'Ext.grid.column.Column',
        'Ext.button.Button',
        'Ext.menu.Menu',
        'Ext.menu.CheckItem',
        'Ext.form.field.Text',
        'Ext.toolbar.Paging'
    ],

    viewModel: {
        type: 'companymembergridpanel'
    },
    defaultListenerScope: true,
    id: 'companymembergridpanel',

    bind: {
        store: '{CompanyMemberStore}'
    },
    selModel: {
        selType: 'checkboxmodel',
        mode: 'SINGLE'
    },
    columns: [
        {
            xtype: 'gridcolumn',
            dataIndex: 'cm_id',
            text: '編號',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'cm_account',
            text: '登入帳號',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'cm_title',
            text: '公司名稱',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'cm_contact_name',
            text: '窗口姓名',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'cm_contact_phone',
            text: '窗口電話',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                if( value == 1 ){
                    return '啟用';
                }else{
                    return '停用';
                }
            },
            dataIndex: 'cm_status',
            text: '啟／停用',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'cm_created',
            text: '建立時間',
            flex: 1
        }
    ],
    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'button',
                    text: '查看詳細資訊',
                    menu: {
                        xtype: 'menu',
                        width: 120,
                        items: [
                            {
                                xtype: 'menucheckitem',
                                text: '刪除',
                                listeners: {
                                    click: 'onMenucheckitemClick2'
                                }
                            },
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
                                text: '刪除',
                                listeners: {
                                    click: 'onMenuitemClick2'
                                }
                            }
                        ]
                    }
                },
                {
                    xtype: 'textfield',
                    id: 'CompanyMemberNameField',
                    name: 'companymembernamefield',
                    emptyText: '公司名稱/登入帳號 搜尋'
                },
                {
                    xtype: 'button',
                    text: '查詢',
                    listeners: {
                        click: 'onButtonClick'
                    }
                },
                {
                    xtype: 'button',
                    text: '清除搜尋結果',
                    listeners: {
                        click: 'onButtonClick1'
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
                store: '{CompanyMemberStore}'
            }
        }
    ],

    onMenucheckitemClick2: function(item, e, eOpts) {

    },

    onMenuitemClick: function(item, e, eOpts) {

    },

    onMenuitemClick1: function(item, e, eOpts) {

    },

    onMenuitemClick2: function(item, e, eOpts) {

    },

    onButtonClick: function(button, e, eOpts) {
        var mName = Ext.getCmp('CompanyMemberNameField').getValue();
        var store  = Ext.getCmp('companymembergridpanel').getViewModel().getStore('CompanyMemberStore');

        store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/company_member?q='+mName;
        store.load();
    },

    onButtonClick1: function(button, e, eOpts) {
        var store  = Ext.getCmp('companymembergridpanel').getViewModel().getStore('CompanyMemberStore');
        store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/company_member';

        Ext.getCmp('CompanyMemberNameField').setValue('');

        store.load();
    }

});
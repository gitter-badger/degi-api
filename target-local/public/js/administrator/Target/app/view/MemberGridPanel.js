/*
 * File: app/view/MemberGridPanel.js
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

Ext.define('Target.view.MemberGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.membergridpanel',

    requires: [
        'Target.view.MemberGridPanelViewModel',
        'Ext.grid.View',
        'Ext.selection.CheckboxModel',
        'Ext.grid.column.Column',
        'Ext.button.Button',
        'Ext.menu.Menu',
        'Ext.menu.Item',
        'Ext.form.field.ComboBox',
        'Ext.toolbar.Paging'
    ],

    viewModel: {
        type: 'membergridpanel'
    },
    defaultListenerScope: true,
    id: 'membergridpanel',
    title: 'My Grid Panel',

    bind: {
        store: '{MemberStore}'
    },
    selModel: {
        selType: 'checkboxmodel',
        mode: 'SINGLE'
    },
    columns: [
        {
            xtype: 'gridcolumn',
            dataIndex: 'mm_id',
            text: 'ID',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'mm_email',
            text: '電子信箱',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'mm_purchaser_name',
            text: '訂購人姓名',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'mm_purchaser_phone',
            text: '訂購人電話',
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
            dataIndex: 'mm_status',
            text: '啟／停用',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'mm_created',
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
                    listeners: {
                        click: 'onButtonClick2'
                    }
                },
                {
                    xtype: 'button',
                    text: '狀態更改',
                    menu: {
                        xtype: 'menu',
                        items: [
                            {
                                xtype: 'menuitem',
                                text: '啟用',
                                listeners: {
                                    click: 'onMenuitemClick'
                                }
                            },
                            {
                                xtype: 'menuitem',
                                text: '停用',
                                listeners: {
                                    click: 'onMenuitemClick1'
                                }
                            }
                        ]
                    }
                },
                {
                    xtype: 'textfield',
                    id: 'MemberNameField',
                    fieldLabel: '',
                    name: 'membernamefield',
                    emptyText: '會員姓名/email 搜尋'
                },
                {
                    xtype: 'button',
                    text: '查詢',
                    listeners: {
                        click: 'onButtonClick'
                    }
                },
                {
                    xtype: 'combobox',
                    id: 'memberStatusSelector',
                    fieldLabel: '',
                    editable: false,
                    emptyText: '狀態查詢',
                    queryMode: 'local',
                    valueField: 'mm_status',
                    bind: {
                        store: '{MemberStatusStore}'
                    },
                    listeners: {
                        change: 'onComboboxChange',
                        focus: 'onComboboxFocus'
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
                store: '{MemberStore}'
            }
        }
    ],

    onButtonClick2: function(button, e, eOpts) {
                var selmodel = Ext.getCmp('membergridpanel').getSelectionModel();
                var count = selmodel.getCount();

                if(count !== 0){
                    var seldata = selmodel.getSelection();

                    var window = Ext.create('Target.view.MemberWindow');

                    Ext.getCmp('mm_id').setValue(seldata[0].data.mm_id);

                    window.setConfig('title', '會員資料');

                    Ext.getCmp('memberForm').getForm().setValues(seldata[0].data);

                    window.show();
                }else{
                    Ext.Msg.alert('訊息', '請選擇一個會員檢視');
                }
    },

    onMenuitemClick: function(item, e, eOpts) {
             /* 啟用會員 */
                var selmodel = Ext.getCmp('membergridpanel').getSelectionModel();
                var seldata = selmodel.getSelection();
                var count = selmodel.getCount();

                if(count !== 0){
                    Ext.Msg.confirm('訊息','確定是否要啟用該會員！',function(buttonId){
                        if(buttonId == 'yes'){
                            var selmodel = Ext.getCmp('membergridpanel').getSelectionModel();
                            var seldata = selmodel.getSelection();

                            Ext.Ajax.request({
                                params: {
                                    mm_status: 1
                                },
                                url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/member/'+seldata[0].data.mm_id,
                                method: 'PUT',
                                success: function(response, option){
                                    var store = Ext.getCmp('membergridpanel').getViewModel().getStore('MemberStore');
                                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/member';
                                    store.load();
                                    Ext.Msg.alert('訊息','啟用會員成功');
                                },
                                failure: function(response, option){
                                    Ext.Msg.alert('訊息','啟用會員失敗');
                                }
                            });
                        }
                    });
                }else{
                    Ext.Msg.alert('訊息','請選擇ㄧ個會員做啟用');
                }

    },

    onMenuitemClick1: function(item, e, eOpts) {
             /* 停用會員 */
                var selmodel = Ext.getCmp('membergridpanel').getSelectionModel();
                var seldata = selmodel.getSelection();
                var count = selmodel.getCount();

                if(count !== 0){
                    Ext.Msg.confirm('訊息','確定是否要停用該會員！',function(buttonId){
                        if(buttonId == 'yes'){
                            var selmodel = Ext.getCmp('membergridpanel').getSelectionModel();
                            var seldata = selmodel.getSelection();
                            //console.log(seldata[0].data.a_id);

                            Ext.Ajax.request({
                                url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/member/'+seldata[0].data.mm_id,
                                method: 'DELETE',
                                success: function(response, option){
                                    var store = Ext.getCmp('membergridpanel').getViewModel().getStore('MemberStore');
                                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/member';
                                    store.load();
                                    Ext.Msg.alert('訊息','停用會員成功');
                                },
                                failure: function(response, option){
                                    Ext.Msg.alert('訊息','停用會員失敗');
                                }
                            });
                        }
                    });
                }else{
                    Ext.Msg.alert('訊息','請選擇ㄧ個會員做停用');
                }

    },

    onButtonClick: function(button, e, eOpts) {
        var mName = Ext.getCmp('MemberNameField').getValue();
        var store  = Ext.getCmp('membergridpanel').getViewModel().getStore('MemberStore');

        store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/member?q='+mName;
        store.load();
    },

    onComboboxChange: function(field, newValue, oldValue, eOpts) {
        var mStatus = Ext.getCmp('memberStatusSelector').getValue();
        var store  = Ext.getCmp('membergridpanel').getViewModel().getStore('MemberStore');
        if( mStatus === '' ){
            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/member';
        }else{
            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/member?s='+mStatus;
        }
        store.load();
    },

    onComboboxFocus: function(component, event, eOpts) {
        var mStatus = Ext.getCmp('memberStatusSelector').setValue('');
    },

    onButtonClick1: function(button, e, eOpts) {
        var store  = Ext.getCmp('membergridpanel').getViewModel().getStore('MemberStore');
        store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/member';

        Ext.getCmp('MemberNameField').setValue('');
        Ext.getCmp('memberStatusSelector').setValue('');

        store.load();
    }

});
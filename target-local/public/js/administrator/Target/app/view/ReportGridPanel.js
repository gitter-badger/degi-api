/*
 * File: app/view/ReportGridPanel.js
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

Ext.define('Target.view.ReportGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.reportgridpanel',

    requires: [
        'Target.view.ReportGridPanelViewModel',
        'Ext.grid.View',
        'Ext.grid.column.Column',
        'Ext.toolbar.Paging',
        'Ext.button.Button',
        'Ext.form.field.ComboBox',
        'Ext.selection.CheckboxModel'
    ],

    viewModel: {
        type: 'reportgridpanel'
    },
    id: 'reportgridpanel',
    title: 'My Grid Panel',
    defaultListenerScope: true,

    bind: {
        store: '{ReportStore}'
    },
    columns: [
        {
            xtype: 'gridcolumn',
            dataIndex: 'rp_id',
            text: 'ID',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'rp_type',
            text: '類型',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'rp_status',
            text: '處理狀況',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'rp_date',
            text: '回報日期',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'm_id',
            text: '會員ID',
            flex: 0.5
        }
    ],
    dockedItems: [
        {
            xtype: 'pagingtoolbar',
            dock: 'bottom',
            width: 360,
            displayInfo: true,
            bind: {
                store: '{ReportStore}'
            }
        },
        {
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'button',
                    text: '修改',
                    listeners: {
                        click: 'onButtonClick'
                    }
                },
                {
                    xtype: 'textfield',
                    id: 'ReportMemberIDField',
                    name: 'reportmemberidfield',
                    emptyText: '回報會員ID查詢'
                },
                {
                    xtype: 'button',
                    text: '查詢',
                    listeners: {
                        click: 'onButtonClick1'
                    }
                },
                {
                    xtype: 'combobox',
                    id: 'reportStatusSelector',
                    editable: false,
                    emptyText: '類型查詢',
                    queryMode: 'local',
                    valueField: 'rp_type',
                    bind: {
                        store: '{ReportStatusStore}'
                    },
                    listeners: {
                        change: 'onReportStatusSelectorChange',
                        focus: 'onReportStatusSelectorFocus'
                    }
                },
                {
                    xtype: 'button',
                    text: '清除查詢結果',
                    listeners: {
                        click: 'onButtonClick2'
                    }
                }
            ]
        }
    ],
    selModel: {
        selType: 'checkboxmodel',
        mode: 'SINGLE'
    },

    onButtonClick: function(button, e, eOpts) {
        /* 修改資料回報 */
        var selmodel = Ext.getCmp('reportgridpanel').getSelectionModel();
        var count = selmodel.getCount();

        if(count !== 0){
            var seldata = selmodel.getSelection();

            var window = Ext.create('Posh.view.ReportWindow');

            Ext.getCmp('rp_id').setValue(seldata[0].data.rp_id);

            window.setConfig('title', '修改資料回報');

        //     Ext.Ajax.request({
        //         url: 'http://dev.finpo.com.tw/posh/public/b/report/'+seldata[0].data.rp_id,
        //         success: function(response, opts){
        //             var obj = Ext.decode(response.responseText);

        //             Ext.getCmp('reportForm').getForm().setValues(obj.data);
        //         },
        //         failure: function(response, opts){
        //             console.log('server-side failure with status code ' + response.status);
        //         }

        //     });

            //Ext.getCmp('productAddBtn').setVisible(false);
            //Ext.getCmp('productUpdateBtn').setVisible(true);

            window.show();
        }else{
            Ext.Msg.alert('訊息', '請選擇一個回報資料修改');
        }

    },

    onButtonClick1: function(button, e, eOpts) {
        var rpMemberId = Ext.getCmp('ReportMemberIDField').getValue();
        var store  = Ext.getCmp('reportgridpanel').getViewModel().getStore('ReportStore');

        store.proxy.url='http://dev.finpo.com.tw/posh/public/b/report?m_id='+rpMemberId;
        store.load();
    },

    onReportStatusSelectorChange: function(field, newValue, oldValue, eOpts) {
        var rpStatus = Ext.getCmp('reportStatusSelector').getValue();
        var store  = Ext.getCmp('reportgridpanel').getViewModel().getStore('ReportStore');
        var rpMemberId = Ext.getCmp('ReportMemberIDField').getValue();
        if( rpStatus === '' ){
            store.proxy.url='http://dev.finpo.com.tw/posh/public/b/report';
        }else{

            if(rpMemberId === ''){
                store.proxy.url='http://dev.finpo.com.tw/posh/public/b/report?rp_type='+rpStatus;
            }else{
                store.proxy.url='http://dev.finpo.com.tw/posh/public/b/report?m_id='+rpMemberId+'&rp_type='+rpStatus;
            }
        }
        store.load();
    },

    onReportStatusSelectorFocus: function(component, event, eOpts) {
        var rpStatus = Ext.getCmp('reportStatusSelector').setValue('');
    },

    onButtonClick2: function(button, e, eOpts) {
        var store  = Ext.getCmp('reportgridpanel').getViewModel().getStore('ReportStore');
        store.proxy.url='http://dev.finpo.com.tw/posh/public/b/report';

        Ext.getCmp('ReportMemberIDField').setValue('');
        Ext.getCmp('reportStatusSelector').setValue('');

        store.load();
    }

});
/*
 * File: app/view/BPOrderGridPanel.js
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

Ext.define('Target.view.BPOrderGridPanel', {
    extend: 'Ext.grid.Panel',
    alias: 'widget.bpordergridpanel',

    requires: [
        'Target.view.BPGridPanelViewModel',
        'Ext.grid.View',
        'Ext.grid.column.Column',
        'Ext.selection.CheckboxModel',
        'Ext.button.Button',
        'Ext.menu.Menu',
        'Ext.menu.Item',
        'Ext.form.field.ComboBox',
        'Ext.toolbar.Paging'
    ],

    viewModel: {
        type: 'bpordergridpanel'
    },
    id: 'bpordergridpanel',
    width: 705,
    defaultListenerScope: true,

    bind: {
        store: '{BPOrderStore}'
    },
    columns: [
        {
            xtype: 'gridcolumn',
            dataIndex: 'bpom_order_number',
            text: '訂單編號',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'cm_id',
            text: '會員編號',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'cmp_name',
            text: '配送點',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'bpom_delivery_year',
            text: '希望送達年',
            flex: 1
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'bpom_delivery_month',
            text: '月',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'bpom_delivery_day',
            text: '日',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'bpom_delivery_hour',
            text: '時',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'bpom_subtotal',
            text: '消費金額',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'bpom_shipping_fee',
            text: ' 運費',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {
                if( value == 1 ){
                    return '未處理';
                }else if ( value == 2 ){
                    return '處理中';
                }else if ( value == 3 ){
                    return '已出貨';
                }else{
                    return '已取消';
                }
            },
            dataIndex: 'bpom_status',
            text: '出貨狀態',
            flex: 0.5
        },
        {
            xtype: 'gridcolumn',
            dataIndex: 'bpom_created',
            text: '建立日期',
            flex: 1
        }
    ],
    selModel: {
        selType: 'checkboxmodel',
        mode: 'SINGLE'
    },
    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'button',
                    text: '查看詳細資訊',
                    listeners: {
                        click: 'onButtonClick'
                    }
                },
                {
                    xtype: 'button',
                    text: '出貨狀態更改',
                    menu: {
                        xtype: 'menu',
                        items: [
                            {
                                xtype: 'menuitem',
                                text: '未處理',
                                listeners: {
                                    click: 'onMenuitemClick111'
                                }
                            },
                            {
                                xtype: 'menuitem',
                                text: '處理中',
                                listeners: {
                                    click: 'onMenuitemClick21'
                                }
                            },
                            {
                                xtype: 'menuitem',
                                text: '已出貨',
                                listeners: {
                                    click: 'onMenuitemClick1111'
                                }
                            },
                            {
                                xtype: 'menuitem',
                                text: '取消訂單',
                                listeners: {
                                    click: 'onMenuitemClick11111'
                                }
                            }
                        ]
                    }
                },
                {
                    xtype: 'combobox',
                    id: 'BPOMStatusSelector',
                    width: 100,
                    fieldLabel: '',
                    editable: false,
                    emptyText: '狀態查詢',
                    queryMode: 'local',
                    valueField: 'bpom_status',
                    bind: {
                        store: '{BPOMStatusStore}'
                    },
                    listeners: {
                        change: 'onComboboxChange1',
                        focus: 'onComboboxFocus1'
                    }
                },
                {
                    xtype: 'button',
                    width: 100,
                    text: '清除搜尋結果',
                    listeners: {
                        click: 'onButtonClick111'
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
                store: '{BPOrderStore}'
            }
        }
    ],

    onButtonClick: function(button, e, eOpts) {
        var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
        var count = selmodel.getCount();

        if(count !== 0){
            var seldata = selmodel.getSelection();
            var window = Ext.create('Target.view.BPOrderWindow');

            window.setConfig('title', '訂單詳細資訊');


            Ext.Ajax.request({

                url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder/'+seldata[0].data.bpom_id,
                success: function(response, opts){
                    //console.log(seldata[0].data.om_id);

                    var obj = Ext.JSON.decode(response.responseText);
                   // console.log(obj.data[0].bpom_content_json);

                    var form = Ext.getCmp('bporderForm').getForm();
                    form.setValues(obj.data[0]);

                    var store = Ext.getCmp('bpsuborderpanel').getStore();

                    if(obj.data[0].bpom_content_json){
                        store.removeAll();
                        var suborder_detail = Ext.JSON.decode(obj.data[0].bpom_content_json);

                       // console.log(suborder_detail.length);

                        for( var i=0; i<(suborder_detail.length); i++){
                            store.add({
                                bpi_id : suborder_detail[i].bpi_id,
                                bpi_flavor : suborder_detail[i].bpi_flavor,
                                im_id : suborder_detail[i].im_id,
                                bpi_name : suborder_detail[i].bpi_name,
                                ic_id : suborder_detail[i].ic_id,
                                bpi_category : suborder_detail[i].bpi_category,
                                bpi_price : suborder_detail[i].bpi_price,
                                bpi_sprice : suborder_detail[i].bpi_sprice,
                                count : suborder_detail[i].count
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
                window.show();
                }else{
                    Ext.Msg.alert('訊息', '請選擇一筆訂單查詢');
                }
    },

    onMenuitemClick111: function(item, e, eOpts) {
         /* 出貨狀態 標示為未處理*/
        var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
        var seldata = selmodel.getSelection();
        var count = selmodel.getCount();

        if(count !== 0){
            Ext.Msg.confirm('訊息','確定此訂單尚未處理？',function(buttonId){
                if(buttonId == 'yes'){
                    var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
                    var seldata = selmodel.getSelection();

                    Ext.Ajax.request({
                        params: {
                            bpom_status: 1
                        },
                        url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder/'+seldata[0].data.bpom_id,
                        method: 'PUT',
                        success: function(response, option){
                            var store = Ext.getCmp('bpordergridpanel').getViewModel().getStore('BPOrderStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder';
                            store.load();
                            Ext.Msg.alert('訊息','此訂單尚未處理 更新成功');
                        },
                        failure: function(response, option){
                            Ext.Msg.alert('訊息','此訂單更新錯誤');
                        }
                    });
                }
            });
        }else{
            Ext.Msg.alert('訊息','請選擇ㄧ筆訂單改成尚未處理');
        }
    },

    onMenuitemClick21: function(item, e, eOpts) {
         /* 出貨狀態 標示為處理中*/
        var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
        var seldata = selmodel.getSelection();
        var count = selmodel.getCount();

        if(count !== 0){
            Ext.Msg.confirm('訊息','確定此訂單處理中？',function(buttonId){
                if(buttonId == 'yes'){
                    var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
                    var seldata = selmodel.getSelection();

                    Ext.Ajax.request({
                        params: {
                            bpom_status: 2
                        },
                        url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder/'+seldata[0].data.bpom_id,
                        method: 'PUT',
                        success: function(response, option){
                            var store = Ext.getCmp('bpordergridpanel').getViewModel().getStore('BPOrderStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder';
                            store.load();
                            Ext.Msg.alert('訊息','此訂單處理中 更新成功');
                        },
                        failure: function(response, option){
                            Ext.Msg.alert('訊息','此訂單更新錯誤');
                        }
                    });
                }
            });
        }else{
            Ext.Msg.alert('訊息','請選擇ㄧ筆訂單改成處理中');
        }

    },

    onMenuitemClick1111: function(item, e, eOpts) {
         /* 出貨狀態 標示為已出貨*/
        var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
        var seldata = selmodel.getSelection();
        var count = selmodel.getCount();

        if(count !== 0){
            Ext.Msg.confirm('訊息','確定此訂單已出貨？',function(buttonId){
                if(buttonId == 'yes'){
                    var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
                    var seldata = selmodel.getSelection();

                    Ext.Ajax.request({
                        params: {
                            bpom_status: 3
                        },
                        url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder/'+seldata[0].data.bpom_id,
                        method: 'PUT',
                        success: function(response, option){
                            var store = Ext.getCmp('bpordergridpanel').getViewModel().getStore('BPOrderStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder';
                            store.load();
                            Ext.Msg.alert('訊息','此訂單已出貨 更新成功');
                        },
                        failure: function(response, option){
                            Ext.Msg.alert('訊息','此訂單更新錯誤');
                        }
                    });
                }
            });
        }else{
            Ext.Msg.alert('訊息','請選擇ㄧ筆訂單改成已出貨');
        }
    },

    onMenuitemClick11111: function(item, e, eOpts) {
         /* 出貨狀態 標示為已取消*/
        var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
        var seldata = selmodel.getSelection();
        var count = selmodel.getCount();

        if(count !== 0){
            Ext.Msg.confirm('訊息','確定取消此訂單？',function(buttonId){
                if(buttonId == 'yes'){
                    var selmodel = Ext.getCmp('bpordergridpanel').getSelectionModel();
                    var seldata = selmodel.getSelection();

                    Ext.Ajax.request({
                        params: {
                            bpom_status: 4
                        },
                        url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder/'+seldata[0].data.bpom_id,
                        method: 'PUT',
                        success: function(response, option){
                            var store = Ext.getCmp('bpordergridpanel').getViewModel().getStore('BPOrderStore');
                            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder';
                            store.load();
                            Ext.Msg.alert('訊息','取消此訂單 更新成功');
                        },
                        failure: function(response, option){
                            Ext.Msg.alert('訊息','取消此訂單 更新錯誤');
                        }
                    });
                }
            });
        }else{
            Ext.Msg.alert('訊息','請選擇ㄧ筆訂單取消');
        }
    },

    onComboboxChange1: function(field, newValue, oldValue, eOpts) {
        var Status = Ext.getCmp('BPOMStatusSelector').getValue();
        var store  = Ext.getCmp('bpordergridpanel').getViewModel().getStore('BPOrderStore');
        if( Status === '' ){
            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder';
        }else{
            store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder?s='+Status;
        }
        store.load();
    },

    onComboboxFocus1: function(component, event, eOpts) {
        var Status = Ext.getCmp('BPOMStatusSelector').setValue('');
    },

    onButtonClick111: function(button, e, eOpts) {
        var store  = Ext.getCmp('bpordergridpanel').getViewModel().getStore('BPOrderStore');
        store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/bporder';

        Ext.getCmp('BPOMStatusSelector').setValue('');

        store.load();
    }

});
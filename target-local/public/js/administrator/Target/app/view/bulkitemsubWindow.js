/*
 * File: app/view/bulkitemsubWindow.js
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

Ext.define('Target.view.bulkitemsubWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.bulkitemsubwindow',

    requires: [
        'Target.view.BulkItemSubWindowViewModel',
        'Ext.form.field.Hidden',
        'Ext.form.Panel',
        'Ext.form.field.Text',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button'
    ],

    viewModel: {
        type: 'bulkitemsubwindow'
    },
    height: 258,
    id: 'BulkItemSubWindow',
    width: 431,
    modal: true,
    defaultListenerScope: true,

    items: [
        {
            xtype: 'hiddenfield',
            id: 'bpi_id_tmp',
            name: 'bpi_id'
        },
        {
            xtype: 'form',
            id: 'BulkForm',
            bodyPadding: '20 0 0 0 ',
            items: [
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 343,
                    fieldLabel: '種類名稱',
                    labelAlign: 'right',
                    name: 'bpi_category',
                    editable: false
                },
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 343,
                    fieldLabel: '商品名稱',
                    labelAlign: 'right',
                    name: 'bpi_name',
                    editable: false
                },
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 343,
                    fieldLabel: '口味名稱',
                    labelAlign: 'right',
                    name: 'bpi_flavor',
                    editable: false
                },
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    width: 343,
                    fieldLabel: '原價',
                    labelAlign: 'right',
                    name: 'bpi_price',
                    editable: false
                },
                {
                    xtype: 'textfield',
                    anchor: '80%',
                    fieldLabel: '優惠價',
                    labelAlign: 'right',
                    name: 'bpi_sprice'
                }
            ]
        }
    ],
    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'bottom',
            height: 41,
            layout: {
                type: 'hbox',
                pack: 'end'
            },
            items: [
                {
                    xtype: 'button',
                    id: 'bpisubUpdateBtn',
                    width: 413,
                    text: '修改',
                    listeners: {
                        click: 'onBPIUpdateBtnClick'
                    }
                }
            ]
        }
    ],

    onBPIUpdateBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('BulkForm').getForm();
        var bpiId = Ext.getCmp('bpi_id_tmp').getValue();
        var cm_id = Ext.getCmp('cm_id_bulk').getValue();

        if(form.isValid()){
            form.submit({
                method: 'PUT',
                waitTitle:'訊息',
                waitMsg:'修改資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/bulk_item/'+bpiId,

                success: function(response){
                //var obj = Ext.JSON.decode(response.responseText);
                //console.log(obj);
                     Ext.Ajax.request({
                         url: 'http://dev.finpo.com.tw/degi-api/target-local/public/b/bulk_item/'+cm_id,
                         success: function(response, opts){

                             var obj = Ext.JSON.decode(response.responseText);
                             var store = Ext.getCmp('bulkitempanel').getStore();

                             if(obj.rows){
                                 store.removeAll();
                                 var cmp = Ext.JSON.decode(obj.rows);

                                 for( var i=0; i<(cmp.length); i++){
                                     store.add({
                                         bpi_id : cmp[i].bpi_id,
                                         bpi_flavor : cmp[i].bpi_flavor,
                                         im_id : cmp[i].im_id,
                                         bpi_name : cmp[i].bpi_name,
                                         ic_id : cmp[i].ic_id,
                                         bpi_category : cmp[i].bpi_category,
                                         bpi_price : cmp[i].bpi_price,
                                         bpi_sprice : cmp[i].bpi_sprice,
                                     });
                                 }
                             }else{
                                 store.removeAll();
                             }
                             console.log(store);
                         },
                         failure: function(response, opts){
                             console.log('server-side failure with status code ' + response.status);
                         }

                     });
                     var window = Ext.getCmp('BulkItemSubWindow');
                     window.close();
                     Ext.Msg.alert('訊息','公司會員商品優惠修改成功');

                   },
                   failure:function(form,action){
                        Ext.Msg.alert('訊息','公司會員商品優惠修改失敗');

                   }
            });
        }
    }

});
/*
 * File: app/view/CompanyMemberWindow.js
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

Ext.define('Target.view.CompanyMemberWindow', {
    extend: 'Ext.window.Window',
    alias: 'widget.companymemberwindow',

    requires: [
        'Target.view.CompanyMemberWindowViewModel',
        'Ext.form.field.Hidden',
        'Ext.form.Panel',
        'Ext.form.RadioGroup',
        'Ext.form.field.Radio',
        'Ext.form.field.TextArea',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button'
    ],

    viewModel: {
        type: 'companymemberwindow'
    },
    height: 326,
    id: 'companymemberWindow',
    width: 604,
    modal: true,
    defaultListenerScope: true,

    layout: {
        type: 'vbox',
        align: 'stretch'
    },
    items: [
        {
            xtype: 'hiddenfield',
            flex: 1,
            id: 'cm_id',
            name: 'cm_id'
        },
        {
            xtype: 'hiddenfield',
            flex: 1,
            id: 'cm_passwordTemp',
            name: 'cm_passwordTemp'
        },
        {
            xtype: 'form',
            height: 297,
            id: 'companymemberForm',
            width: 648,
            bodyPadding: 10,
            layout: {
                type: 'vbox',
                align: 'stretch'
            },
            items: [
                {
                    xtype: 'fieldcontainer',
                    flex: 1,
                    height: 290,
                    width: 400,
                    layout: {
                        type: 'hbox',
                        align: 'stretch'
                    },
                    items: [
                        {
                            xtype: 'container',
                            autoScroll: true,
                            height: 347,
                            width: 292,
                            items: [
                                {
                                    xtype: 'textfield',
                                    id: 'cm_account',
                                    fieldLabel: '帳號信箱',
                                    name: 'cm_account'
                                },
                                {
                                    xtype: 'textfield',
                                    id: 'cm_password',
                                    fieldLabel: '密碼',
                                    name: 'cm_password',
                                    inputType: 'password'
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '公司名稱',
                                    name: 'cm_title'
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '聯絡窗口姓名',
                                    name: 'cm_contact_name'
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: '聯絡窗口性別',
                                    allowBlank: false,
                                    layout: {
                                        type: 'checkboxgroup',
                                        autoFlex: false
                                    },
                                    items: [
                                        {
                                            xtype: 'radiofield',
                                            id: 'cm_contact_gender_on',
                                            width: 50,
                                            name: 'cm_contact_gender',
                                            boxLabel: '先生',
                                            inputValue: '1'
                                        },
                                        {
                                            xtype: 'radiofield',
                                            id: 'cm_contact_gender_off',
                                            name: 'cm_contact_gender',
                                            boxLabel: '小姐',
                                            inputValue: '2'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '聯絡窗口電話',
                                    name: 'cm_contact_phone'
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '聯絡窗口手機',
                                    name: 'cm_contact_mobile'
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '消費總計',
                                    name: 'cm_consumption_amount'
                                }
                            ]
                        },
                        {
                            xtype: 'container',
                            flex: 1,
                            autoScroll: true,
                            height: 200,
                            items: [
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '聯絡窗口信箱',
                                    name: 'cm_contact_email'
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '結帳日',
                                    name: 'cm_checkout_day'
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '統一編號',
                                    name: 'cm_ub_number'
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: '發票抬頭',
                                    name: 'cm_invoice_title'
                                },
                                {
                                    xtype: 'textareafield',
                                    fieldLabel: '發票寄送地址',
                                    name: 'cm_invoice_address'
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: '結帳方式',
                                    allowBlank: false,
                                    layout: {
                                        type: 'checkboxgroup',
                                        autoFlex: false
                                    },
                                    items: [
                                        {
                                            xtype: 'radiofield',
                                            id: 'cm_pay_method_on',
                                            width: 80,
                                            name: 'cm_pay_method',
                                            boxLabel: '貨到付款',
                                            inputValue: '1'
                                        },
                                        {
                                            xtype: 'radiofield',
                                            id: 'cm_pay_method_off',
                                            name: 'cm_pay_method',
                                            boxLabel: '月結',
                                            inputValue: '2'
                                        }
                                    ]
                                },
                                {
                                    xtype: 'radiogroup',
                                    fieldLabel: '狀態',
                                    allowBlank: false,
                                    layout: {
                                        type: 'checkboxgroup',
                                        autoFlex: false
                                    },
                                    items: [
                                        {
                                            xtype: 'radiofield',
                                            id: 'cm_status_on',
                                            width: 50,
                                            name: 'cm_status',
                                            boxLabel: '啟用',
                                            inputValue: '1'
                                        },
                                        {
                                            xtype: 'radiofield',
                                            id: 'cm_status_off',
                                            name: 'cm_status',
                                            boxLabel: '停用',
                                            inputValue: '2'
                                        }
                                    ]
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ],
    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'bottom',
            flex: 1,
            height: 41,
            layout: {
                type: 'hbox',
                pack: 'end'
            },
            items: [
                {
                    xtype: 'button',
                    height: 25,
                    id: 'cmAddBtn',
                    width: 585,
                    text: '新增',
                    listeners: {
                        click: 'onCmAddBtnClick'
                    }
                },
                {
                    xtype: 'button',
                    height: 25,
                    id: 'cmUpdateBtn',
                    width: 585,
                    text: '修改',
                    listeners: {
                        click: 'onCmUpdateBtnClick'
                    }
                }
            ]
        }
    ],

    onCmAddBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('companymemberForm').getForm();

        if(form.isValid()){
            form.submit({

                waitTitle:'訊息',
                waitMsg:'新增資料中',
                url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/company_member',

                success:function(form,action){

                    var store  = Ext.getCmp('companymembergridpanel').getViewModel().getStore('CompanyMemberStore');
                    store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/company_member';
                    store.load();
                    var window = Ext.getCmp('companymemberWindow');
                    window.close();
                    //form.reset();
                    Ext.Msg.alert('訊息','公司會員新增成功');

                },
                failure:function(form,action){

                   Ext.Msg.alert('訊息','公司會員新增失敗');

                }

            });
        }
    },

    onCmUpdateBtnClick: function(button, e, eOpts) {
        var form = Ext.getCmp('companymemberForm').getForm();

        if(form.isValid()){
            var cmId = Ext.getCmp('cm_id').getValue();
            var cmPassword = Ext.getCmp('cm_password').getValue();
            var cmPasswordTemp = Ext.getCmp('cm_passwordTemp').getValue();

            var cmStatusOn = Ext.getCmp('cm_status_on').getValue();
            var cmStatusOff = Ext.getCmp('cm_status_off').getValue();
            var cmStatus = 0;
            if(cmStatusOn === true && cmStatusOff === false){
                cmStatus = 1;
            }else if(cmStatusOn === false && cmStatusOff === true){
                cmStatus = 2;
            }else{
                cmStatus = 2;
            }

            var cmGenderOn = Ext.getCmp('cm_contact_gender_on').getValue();
            var cmGenderOff = Ext.getCmp('cm_contact_gender_off').getValue();
            var cmGender = 0;
            if(cmGenderOn === true && cmGenderOff === false){
                cmGender = 1;
            }else if(cmGenderOn === false && cmGenderOff === true){
                cmGender = 2;
            }else{
                cmGender = 2;
            }

            var cmPayOn = Ext.getCmp('cm_pay_method_on').getValue();
            var cmPayOff = Ext.getCmp('cm_pay_method_off').getValue();
            var cmPay = 0;
            if(cmPayOn === true && cmPayOff === false){
                cmPay = 1;
            }else if(cmPayOn === false && cmPayOff === true){
                cmPay = 2;
            }else{
                cmPay = 2;
            }

            if(cmPassword === cmPasswordTemp){
                Ext.Ajax.request({
                    method: 'PUT',
                    url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/company_member/'+cmId,
                    params: {
                        cm_account: form.findField('cm_account').getValue(),
                        cm_title: form.findField('cm_title').getValue(),
                        cm_contact_name: form.findField('cm_contact_name').getValue(),
                        cm_contact_gender: cmGender,
                        cm_contact_phone: form.findField('cm_contact_phone').getValue(),
                        cm_contact_mobile: form.findField('cm_contact_mobile').getValue(),
                        cm_contact_email: form.findField('cm_contact_email').getValue(),
                        cm_checkout_day: form.findField('cm_checkout_day').getValue(),
                        cm_ub_number: form.findField('cm_ub_number').getValue(),
                        cm_invoice_title: form.findField('cm_invoice_title').getValue(),
                        cm_invoice_address: form.findField('cm_invoice_address').getValue(),
                        cm_consumption_amount: form.findField('cm_consumption_amount').getValue(),
                        cm_pay_method: cmPay,
                        cm_status: cmStatus
                    },
                    success: function(response, options){
                        var obj = Ext.JSON.decode(response.responseText);
                        var store  = Ext.getCmp('companymembergridpanel').getViewModel().getStore('CompanyMemberStore');
                        store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/company_member';
                        store.load();

                        //form.reset();
                        Ext.Msg.alert('訊息','公司會員修改成功', function(){
                            var window = Ext.getCmp('companymemberWindow');
                            window.close();
                        });
                    }
                });
            }else{
                form.submit({
                    method: 'PUT',
                    waitTitle:'訊息',
                    waitMsg:'修改資料中',
                    url:'http://dev.finpo.com.tw/degi-api/target-local/public/b/company_member/'+cmId,

                    success:function(form,action){

                        var store  = Ext.getCmp('companymembergridpanel').getViewModel().getStore('CompanyMemberStore');
                        store.proxy.url='http://dev.finpo.com.tw/degi-api/target-local/public/b/company_member';
                        store.load();

                       // form.reset();
                        Ext.Msg.alert('訊息','公司會員修改成功', function(){
                            var window = Ext.getCmp('companymemberWindow');
                            window.close();
                        });

                    },
                    failure:function(form,action){
                        Ext.Msg.alert('訊息','公司會員修改失敗');
                    }
                });

            }

        }
    }

});
/*
 * File: app.js
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

// @require @packageOverrides
Ext.Loader.setConfig({

});


Ext.application({
    models: [
        'AdminModel',
        'MemberModel',
        'ProductModel',
        'ReportModel',
        'ContentModel',
        'OrderModel',
        'ContactCenterModel',
        'ItemCategoryModel',
        'ItemModel',
        'NewsModel',
        'PopularItemModel',
        'SystemVariableModel',
        'ItemMainModel',
        'PopularStatusModel'
    ],
    stores: [
        'SubOrderArrayStore',
        'GroupOrderArrayStore'
    ],
    views: [
        'MyViewport',
        'AdminGridPanel',
        'AdminWindow',
        'MemberGridPanel',
        'MemberWindow',
        'ProductGridPanel',
        'ProductWindow',
        'ReportGridPanel',
        'ReportWindow',
        'ContentGridPanel',
        'OrderGridPanel',
        'LoginWindow',
        'ContactCenterGridPanel',
        'ContactCenterWindow',
        'ItemCategoryGridPanel',
        'ItemGridPanel',
        'NewsGridPanel',
        'PopularItemGridPanel',
        'SystemVariableGridPanel',
        'ItemWindow',
        'ItemCategoryWindow',
        'SystemVariableWindow',
        'popularwindow',
        'OrderWindow',
        'GroupOrderWindow',
        'NewsWindow'
    ],
    name: 'Target',

    launch: function() {
        Ext.create('Target.view.MyViewport');
    }

});

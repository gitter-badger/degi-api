/*
 * File: app/model/OrderModel.js
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

Ext.define('Target.model.OrderModel', {
    extend: 'Ext.data.Model',

    requires: [
        'Ext.data.field.Field'
    ],

    fields: [
        {
            name: 'om_id'
        },
        {
            name: 'om_internal_id'
        },
        {
            name: 'om_subtotal'
        },
        {
            name: 'om_freight_fee'
        },
        {
            name: 'om_full_box'
        },
        {
            name: 'om_unfull_box'
        },
        {
            name: 'om_use_point'
        },
        {
            name: 'om_total'
        },
        {
            name: 'om_get_point'
        },
        {
            name: 'mm_id'
        },
        {
            name: 'om_pruchase'
        },
        {
            name: 'om_purchaser_name'
        },
        {
            name: 'om_purchaser_tel'
        },
        {
            name: 'om_consignee_email'
        },
        {
            name: 'om_consignee_address'
        },
        {
            name: 'om_consignee_name'
        },
        {
            name: 'om_consignee_tel'
        },
        {
            name: 'om_payment_method'
        },
        {
            name: 'om_payment_status'
        },
        {
            name: 'om_note'
        },
        {
            name: 'om_status'
        },
        {
            name: 'om_content_json'
        },
        {
            name: 'om_group_buying_info'
        },
        {
            name: 'om_created'
        }
    ]
});
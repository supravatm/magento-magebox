define([
    'Magento_Payment/js/view/payment/cc-form',
    'jquery',
    'Magento_Payment/js/model/credit-card-validation/validator'
], function (Component, $) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'SMG_MockOnlinePayment/payment/mockonlinepayment',
            code: 'mockonlinepayment'
        },


        getCode: function () {
            return this.code;
        },

        isActive: function () {
            return this.code === this.isChecked();
        },

        validate: function () {
            const form = $('#' + this.getCode() + '_payment-form');
            if (form.length === 0) {
                return false;
            }

            form.validation();
            return form.valid();
        }
    });
});
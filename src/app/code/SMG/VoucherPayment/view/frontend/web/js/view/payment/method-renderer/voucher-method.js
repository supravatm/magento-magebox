define([
    'Magento_Checkout/js/view/payment/default',
    'jquery',
    'mage/validation'
], function (Component, $) {
    'use strict';


    return Component.extend({

        defaults: {
            template: 'SMG_VoucherPayment/payment/voucher-form',
            voucherNumber: ''
        },

        /** @inheritdoc */
        initObservable: function () {
            this._super()
                .observe('voucherNumber');

            return this;
        },

        /**
         * @return {Object}
         */
        getData: function () {
            return {
                method: this.item.method,
                extension_attributes: {
                    'voucher_number': this.voucherNumber(),
                }
            };
        },

        /**
         * @return {jQuery}
         */
        validate: function () {
            var form = 'form[data-role=voucherpayment-form]';

            return $(form).validation() && $(form).validation('isValid');
        }
    });
});
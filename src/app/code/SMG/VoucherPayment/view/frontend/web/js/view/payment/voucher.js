define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';

    rendererList.push(
        {
            type: 'voucherpayment', // must equals the payment code
            component: 'SMG_VoucherPayment/js/view/payment/method-renderer/voucher-method'
        }
    );

    /** Add view logic here if you needed */
    return Component.extend({});
});
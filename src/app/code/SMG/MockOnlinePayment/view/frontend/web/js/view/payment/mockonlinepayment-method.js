define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (
    Component,
    rendererList
) {
    'use strict';

    rendererList.push({
        type: 'mockonlinepayment', // must equals the payment code
        component: 'SMG_MockOnlinePayment/js/view/payment/method-renderer/mockonlinepayment'
    });

    return Component.extend({});
});
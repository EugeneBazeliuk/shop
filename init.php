<?php

//// Update order total
//Event::listen('djetson.shop.order.updateTotal', function(Djetson\Shop\Models\Order $order) {
//
////    $order->subtotal = $order->items->sum('total');
////
////    // Check if payment method is changed
////    if ($order->checkDifference('subtotal') || $order->checkDifference('payment_method_id')) {
////        $order->payment_cost = $order->payment_method->getCost($order);
////    }
////
////    // Check if shipping method is changed
////    if ($order->checkDifference('subtotal') || $order->checkDifference('shipping_method_id')) {
////        $order->shipping_cost = $order->shipping_method->getCost($order);
////    }
////
////    // Update Order
////    if ($order->checkDifference('subtotal') || $order->checkDifference('payment_method_id') || $order->checkDifference('shipping_method_id')) {
////        $order->total = $order->subtotal + $order->payment_cost + $order->shipping_cost;
////    }
//
//});














//// Event order
//Event::listen('djetson.shop.orders.*', function(Djetson\Shop\Models\Order $order) {
//
//    switch (Event::firing()) {
//        case 'djetson.shop.orders.create':
//            $message = 'Order Created';
//            break;
//        case 'djetson.shop.orders.update':
//            $message = 'Order Updated';
//            break;
//        default:
//            return;
//    }
//
//    $order->histories()->create([
//        'message' => $message,
//        'manager_id' => $order->getManagerId()
//    ]);
//});


<?php
 
namespace App\Listeners;

use App\Models\Order;
use App\Models\Payments;
use LemonSqueezy\Laravel\Events\WebhookHandled;
 
class LemonSqueezyEventListener
{
    /**
     * Handle received Lemon Squeezy webhooks.
     */
    public function handle(WebhookHandled $event): void
    {
        if ($event->payload['meta']['event_name'] === 'order_created') {
            $useremail = $event->payload['meta']['custom_data']['email'];

            Order::create([
                'order_id' => $event->payload['data']['id'],
                'order_status' => $event->payload['data']['attributes']['status'],
                'customer_id' => $event->payload['data']['attributes']['customer_id'],
                'user_email' => $useremail,
                'checkout_email' => $event->payload['data']['attributes']['user_email'],
                'planname' => $event->payload['data']['attributes']['first_order_item']['product_name'],
                'total_price' => $event->payload['data']['attributes']['total_usd'],
                
                'product_id' => $event->payload['data']['attributes']['first_order_item']['product_id'],
                
                // Fill other fields for the current date
            ]);
        }
        if ($event->payload['meta']['event_name'] === 'subscription_created') {
            $useremail = $event->payload['meta']['custom_data']['email'];

            Payments::create([
                'sub_id' => $event->payload['data']['id'],
                'order_id' => $event->payload['data']['attributes']['order_id'],
                'sub_status' => $event->payload['data']['attributes']['status'],
                'customer_id' => $event->payload['data']['attributes']['customer_id'],
                'user_email' => $useremail,
                'checkout_email' => $event->payload['data']['attributes']['user_email'],
                'planname' => $event->payload['data']['attributes']['product_name'],
                // Fill other fields for the current date
            ]);
        }
    }
}
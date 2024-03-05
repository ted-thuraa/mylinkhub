<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PayingCustomers;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LemonWebhookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function webhook(Request $request)
    {
        $secret    = config('lemon-squeezy.signing_secret');
        //$secret    = config('lemon-squeezy.signing_secret');
        
        $payload   = @file_get_contents('php://input');
        $hash      = hash_hmac('sha256', $payload, $secret);
        $signature = $_SERVER['HTTP_X_SIGNATURE'] ?? '';

        if (!hash_equals($hash, $signature)) {
            return new Response(('Invalid signature.'), 400);
        }
        $payloadd = $request->all();
        if (! isset($payloadd['meta']['event_name'])) {
            return new Response(('Webhook received but no event name was found.'), 204);
        }

        if ($payloadd['meta']['event_name'] === 'order_created') {
            if ($payloadd['meta']['custom_data']) {
                $useruuid = $payloadd['meta']['custom_data']['ouid'];
<<<<<<< HEAD
                $user = User::where('uuid', $useruuid)->first();
            }

            Order::create([
                'order_id' => $payloadd['data']['id'],
                'order_status' => $payloadd['data']['attributes']['status'],
                'customer_id' => $payloadd['data']['attributes']['customer_id'],
                'user_email' => $user->email,
                'checkout_email' => $payloadd['data']['attributes']['user_email'],
                'orderitem_id' => $payloadd['data']['attributes']['first_order_item']['order_id'],
                'planname' => $payloadd['data']['attributes']['first_order_item']['product_name'],
                'total_price' => $payloadd['data']['attributes']['total'],
                'total_formatted' => $payloadd['data']['attributes']['total_formatted'],
                
                'product_id' =>$payloadd['data']['attributes']['first_order_item']['product_id'],
                
                // Fill other fields for the current date
            ]);
=======
                $user = User::where('id', $useruuid)->first();
            

                Order::create([
                    'order_id' => $payloadd['data']['id'],
                    'user_id' => $user->id,
                    'order_status' => $payloadd['data']['attributes']['status'],
                    'customer_id' => $payloadd['data']['attributes']['customer_id'],
                    'user_email' => $user->email,
                    'checkout_email' => $payloadd['data']['attributes']['user_email'],
                    'orderitem_id' => $payloadd['data']['attributes']['first_order_item']['order_id'],
                    'planname' => $payloadd['data']['attributes']['first_order_item']['product_name'],
                    'total_price' => $payloadd['data']['attributes']['total'],
                    'total_formatted' => $payloadd['data']['attributes']['total_formatted'],
                    'product_id' =>$payloadd['data']['attributes']['first_order_item']['product_id'],
                    
                    // Fill other fields for the current date
                ]);
            }
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

            if ($payloadd['data']['attributes']['status'] === "paid") {
                //$useremail = $payloadd['meta']['custom_data']['email'];

<<<<<<< HEAD
                $user = User::where('uuid', $useruuid)->first();
                $user->currentplan = $payloadd['data']['attributes']['first_order_item']['product_name'];
=======
                $user = User::where('id', $useruuid)->first();
                $user->currentplan = $payloadd['data']['attributes']['first_order_item']['variant_name'];
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
                $user->save();
                PayingCustomers::create([
                    'user_id' => $user->id,
                    'lemoncustomer_id' => $payloadd['data']['attributes']['customer_id'],
                    'customer_email' => $user->email,
                    'customer_name' => $payloadd['data']['attributes']['user_name'],
                    'product_name' => $payloadd['data']['attributes']['first_order_item']['product_name'],
                    'product_id' =>$payloadd['data']['attributes']['first_order_item']['product_id'],
                    // Fill other fields for the current date
                ]);
                
            }
        }

        return response(('ok'), 200);
       
    }
}

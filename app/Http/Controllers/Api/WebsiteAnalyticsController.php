<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersResource;
use App\Http\Resources\UserResource;
use App\Models\Order;
use App\Models\PayingCustomers;
use App\Models\User;
use Illuminate\Http\Request;

class WebsiteAnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function users()
    {
        return UserResource::collection(
            User::query()->orderBy('id', 'desc')->paginate(10)
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function orders(Request $request)
    {
        
        return OrdersResource::collection(
            Order::query()->orderBy('id', 'desc')->paginate()
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function analytics(Request $request)
    {
        $signups = User::count();
        $payingusers = PayingCustomers::count();
        $totalrevenue = Order::where('order_status', "paid")->sum('total_price');

        $response = [
            "signups" => $signups,
            "payingusers" => $payingusers,
            "totalrevenue" => "$" . number_format($totalrevenue, 2),
        ];

        return response()->json($response);
    }

}

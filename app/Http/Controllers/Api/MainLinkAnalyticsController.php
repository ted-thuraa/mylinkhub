<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Stevebauman\Location\Facades\Location;
use App\Models\Link;
use App\Models\Mainlinkanalytics;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MainLinkAnalyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $linkAnalytics = Mainlinkanalytics::where('user_id', auth()->user()->id)->get();
            return response()->json($linkAnalytics, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function trigger(Request $request)
    {
        $request->validate([
            'username' => 'required',
           
        ]);

        
        $ipAddress = $request->ip();
        $ip = '48.188.144.248'; /* Static IP address */ 
        $userAgent = $request->header('User-Agent');
        $date = now()->toDateString();
        $username = $request->input('username');
        $visitorInfo = Location::get($ip);
        $visitorip = Mainlinkanalytics:: where('ip_address', $ipAddress)->first();
        $uniquevisitor = 0;
        if (!$visitorip)
        {
            $uniquevisitor += 1;
        } else {
            $uniquevisitor = 0;
        }

        return response()->json($visitorInfo, 200);
        
        //  try {
        //     $user = User::where('name', $username)->first();

        //     $linkanalytics = Mainlinkanalytics::firstOrNew(['date' => $date]);

        //     $linkanalytics->user_id = $user->id;
        //     $linkanalytics->name = $user->name;
        //     $linkanalytics->ip_address = $ipAddress;
        //     $linkanalytics->views += 1;
        //     $linkanalytics->clicks = 0;
        //     $linkanalytics->ctr = 0;
        //     $linkanalytics->uniquevisitors += $uniquevisitor;
           

        //     $linkanalytics->save();
        //     $uniquevisitor = 0;
        //     // Delete analytics data older than one month
        //     $oneMonthAgo = Carbon::now()->subMonth()->toDateString();
        //     Mainlinkanalytics::whereDate('date', '<', $oneMonthAgo)->delete();

        //     return response()->json('Analytics data stored successfully', 200);
        //  } catch (\Exception $e) {
        //     $uniquevisitor = 0;
        //      return response()->json(['error' => $e->getMessage()], 400);
        //  }

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function activitytriggger(Request $request, Mainlinkanalytics $Mainlinkanalytics)
    {
        $linkid = $request->input('link_id');
        $username = $request->input('username');
        $date = now()->toDateString();
        //update particular link clicks
        $link = Link::where('id', $linkid )->first();
        $link->clicks += 1;
        $link->save();

        //update page clicks
        $linkanalytics = Mainlinkanalytics::where('date', $date)
        ->where('name', $username)
        ->first();
        if ($linkanalytics) {
            $linkanalytics->clicks += 1;
            $linkanalytics->save();        
        }
        // Calculate CTR
        if ($linkanalytics->views > 0 && $linkanalytics->clicks > 0) {
            $ctr = ($linkanalytics->clicks / $linkanalytics->views) * 100;
        } else {
            $ctr = 0; // Set CTR to 0 if there are no views
        }

        // Update the CTR in the record
        $linkanalytics->ctr = $ctr;
        $linkanalytics->save();
        return response()->json('Analytics data stored successfully', 200);

    }
}

<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\GuestPageLinks;
use App\Http\Resources\PageResource;
use App\Http\Resources\SocialmediaCollection;
use App\Models\Countries;
use App\Models\Link;
use App\Models\Page;
use App\Models\PageViews;
use App\Models\Referrers;
use App\Models\SocialmediaLinks;
use App\Models\User;
use Illuminate\Http\Request;

class GuestPageController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function showForGuest(Request $request, $linkname)
    {
        $user = User::where('username', $linkname)->first();
    
        if (!$user) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    
        $links = Link::where('user_id', $user->id)->where('active', true)->orderBy('order', 'asc')->get();
        $sociallinks = SocialmediaLinks::where('user_id', $user->id)->where('active', true)->get();
    
        //return response()->json(['referrer' => $referrer], 200);
        return response()->json(['page' => new PageResource($user), 'links' => new GuestPageLinks($links), 'SocialIcons' => new SocialmediaCollection($sociallinks)], 200);
    }
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }


    
}

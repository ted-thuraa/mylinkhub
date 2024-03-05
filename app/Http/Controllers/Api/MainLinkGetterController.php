<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuestLinkData;
use App\Http\Resources\GuestPageLinks;
use App\Models\Link;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class MainLinkGetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function linkdata(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|max:20',
                
            ]);
            $name = $request->input('username');
            $page = Page::where('linkname', $name)->first();
          
            return response()->json(new GuestLinkData($page), 200);
          
         
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function pagelinks(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|max:20',
                
            ]);
            $name = $request->input('username');
            $page = Page::where('linkname', $name)->first();
            $links = Link::where('page_id',  $page->id)->get();
            
            return response()->json(new GuestPageLinks($links), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

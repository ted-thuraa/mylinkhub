<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuestPageLinks;
use App\Http\Resources\PageResource;
use App\Models\Link;
use App\Models\Page;
use Illuminate\Http\Request;

class PageGuestController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function showForGuest($linkname)
    {
        $page = Page::where('linkname', $linkname)->first();
    
        if (!$page) {
            return response()->json(['error' => 'Page not found'], 404);
        }
    
        $links = Link::where('page_id', $page->id)->get();
    
        return response()->json(['page' => new PageResource($page), 'links' => new GuestPageLinks($links)], 200);
    }
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}

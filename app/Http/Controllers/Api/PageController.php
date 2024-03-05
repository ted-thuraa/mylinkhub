<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
<<<<<<< HEAD
use App\Models\Page;
use Illuminate\Http\Request;
=======
use App\Models\Link;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
<<<<<<< HEAD
            $page = Page::where('user_id', auth()->user()->id)->first();
=======
            $page = User::where('id', auth()->user()->id)->first();
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            return response()->json($page, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
<<<<<<< HEAD
        //
=======
        
        try {
            
            $user = User::where('id', $request->user()->id)
                ->first();
            
            //$user->username = $request->input('username');
            $user->fullname = $request->input('fullname');
            $user->location = $request->input('location');
            $user->creator_category = $request->input('creator_category');
            $user->bio = $request->input('bio');
            $user->save();
            
            return response()->json($page, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function linkorder(Request $request, Page $page)
    {
        $request->validate([
            
            'payload' => 'array',
            
        ]);
        
        try {
            //$page = Page::where('user_id', auth()->user()->id)->first();
            //$links = Link::where('page_id', $page->id)->get();

             // Assuming each item in the payload has 'id', 'order', and 'page_id' fields
             $payload = $request->input('payload');
            foreach ($payload as $item) {
                $linkId = $item['id'];
                $newOrder = $item['order'];
                
                // Retrieve the link from the database and update the order and page_id values
                $link = Link::find($linkId);
                if ($link) {
                    $link->order = $newOrder;
                    $link->save();
                }
            }

            return response()->json(['message' => 'Order values updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        //
    }
}

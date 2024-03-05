<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialmediaCollection;
use App\Models\Page;
use App\Models\SocialmediaLinks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SocialmediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = User::where('id', auth()->user()->id)->first();
            $sociallinks = SocialmediaLinks::where('user_id', $user->id)->get();
            //return LinksCollection::collection(Link::where('page_id', $page->id)->where('category', "other"));
            return response()->json(new SocialmediaCollection($sociallinks), 200);
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
        $user = User::where('id', auth()->user()->id)->first();
        $request->merge([
            'user_id' =>$user->id
        ]);

        $data = $request->validate([
            'user_id' => 'exists:users,id',
            'url' => 'nullable|active_url',
            'name' => 'required',
            'username' => 'nullable',
            'active' => 'nullable',
            'clicks' => 'nullable',
        ]);

        try {
            $data['active'] = true;
            if ($data['url']){
                $data['active'] = true;
            } 
            $sociallinks = SocialmediaLinks::create($data);
            return response()->json('social icon created', 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialmediaLinks $socialmediaLinks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialmediaLinks $socialmediaLinks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $request->merge([
            'user_id' => $user->id
        ]);

        $data = $request->validate([
            'user_id' => 'exists:users,id',
            'id' => 'required|exists:socialmedia_links,id',
            'url' => 'nullable|active_url',
            'username' => 'nullable',
            'active' => 'nullable',
            
        ]);

        try {
            $data['active'] = false;
            if ($data['url']){
                $data['active'] = true;
            } 
            $socialmediaLink = SocialmediaLinks::where('id', $request->input('id'))->first();
            //$socialmediaLinks->page_id = $request->input('page_id');
            //$socialmediaLinks->url = $request->input('url');
            //$socialmediaLinks->active = $request->input('active');
            //$socialmediaLinks->username = $request->input('username');
            $socialmediaLink->update($data);

            return response()->json('social icon UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, SocialmediaLinks $socialmediaLinks)
    {
        $request->validate([
            'id' => 'required|exists:socialmedia_links,id',
            'url' => 'nullable|active_url',
        ]);

        try {
            $socialmediaLink = SocialmediaLinks::where('id', $request->input('id'))->first();
            $socialmediaLink->delete();

            return response()->json('social icon DELETEED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

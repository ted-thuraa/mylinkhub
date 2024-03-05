<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(['theme_id' => 'required']);

        try {
<<<<<<< HEAD
            $page = Page::where('user_id', auth()->user()->id)->first();

            
            $page->theme_id = $request->input('theme_id');
            $page->save();

            return response()->json([
                'theme_id' => $page->theme_id
=======
            $user = User::where('id', auth()->user()->id)->first();

            
            $user->theme_id = $request->input('theme_id');
            $user->save();

            return response()->json([
                'theme_id' => $user->theme_id
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function pageappearance(Request $request)
    {
        $request->validate([
            'page_font' => 'required',
            'page_layout' => 'required',
        ]);

        try {
            $user = User::where('id', auth()->user()->id)->first();

            
            $user->page_font = $request->input('page_font');
            $user->page_layout = $request->input('page_layout');
            $user->save();

            return response()->json([
                'theme_id' => $user->theme_id
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Page;
<<<<<<< HEAD
=======
use App\Models\PortfolioData;
use App\Models\User;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use App\Services\FileService;
use Illuminate\Http\Request;

class LinkImageController extends Controller
{
     /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        try {
<<<<<<< HEAD
            $page = Page::where('user_id', auth()->user()->id)->first();
            //$links = Link::where('page_id', $page->id)->where('category', "other")->get();
            $link = Link::where('id', $request->input('id'))
                ->where('page_id', $page->id)
=======
            $user = User::where('id', auth()->user()->id)->first();
            //$links = Link::where('page_id', $page->id)->where('category', "other")->get();
            $link = Link::where('id', $request->input('id'))
                ->where('user_id', $user->id)
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
                ->first();
            $link = (new FileService)->updateImage($link, $request);
            $link->save();

            return response()->json('Link IMAGE UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
<<<<<<< HEAD
=======
     /**
     * Update the specified resource in storage.
     */
    public function storethumbnail(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        try {
            $user = User::where('id', auth()->user()->id)->first();
            //$links = Link::where('page_id', $page->id)->where('category', "other")->get();
            $link = Link::where('id', $request->input('id'))
                ->where('user_id', $user->id)
                ->first();
            $link = (new FileService)->updateThumbnailImage($link, $request);
            $link->save();

            return response()->json('Link Thumbnail UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function storeportfoliothumbnail(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        try {
            $user = User::where('user_id', auth()->user()->id)->first();
            //$links = Link::where('page_id', $page->id)->where('category', "other")->get();
            $link = Link::where('id', $request->input('id'))
                ->where('user_id', $user->id)
                ->first();
            $portfolio_data = PortfolioData::where('link_id', $link->id)
                ->first();
            $portfolio_data = (new FileService)->updateportfolioThumbnailImage($portfolio_data, $request);
            $portfolio_data->save();

            return response()->json('Portfolio Thumbnail UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
}

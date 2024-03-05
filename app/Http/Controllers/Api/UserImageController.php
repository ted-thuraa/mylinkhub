<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;

class UserImageController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['image' => 'required|mimes:png,jpg,jpeg']);

        try {
            $user = User::findOrFail(auth()->user()->id);
<<<<<<< HEAD
            $user = (new FileService)->updateImage($user, $request);
            $user->save();

            $page = Page::where('user_id', auth()->user()->id)->firstOrFail();
            $page = (new FileService)->updatePageImage($page, $request);
            $page->save();

=======
            //$user = (new FileService)->updateImage($user, $request);
            $user = (new FileService)->updatePageImage($user, $request);
            $user->save();

>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            return response()->json('USER IMAGE UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

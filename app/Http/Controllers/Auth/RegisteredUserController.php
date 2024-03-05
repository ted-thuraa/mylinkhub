<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pageanalytics;
use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'image' => '/user-placeholder.png',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        //create page
        $page =  Page::create([
            'user_id' => $user->id,
            'linkname' => $user->username,
            'linkbio' => $user->bio,
            'bioimage' => $user->image,
            'theme_id' => 1,
            // Fill other fields with empty values if needed
        ]);

        //start analytics
        $currentDate = Carbon::now();
        $previousDate = Carbon::now()->subDay();
        
        $pageanalytics = Pageanalytics::where('page_id', $page->id)
            ->where('date', $previousDate->toDateString())
            ->first();
        
        if (!$pageanalytics) {
            Pageanalytics::create([
                'page_id' => $page->id,
                'date' => $previousDate->toDateString(),
                
                // Fill other fields with empty values if needed
            ]);
        }
        
        Pageanalytics::create([
            'page_id' => $page->id,
            'date' => $currentDate->toDateString(),
            
            // Fill other fields for the current date
        ]);

        return response('success', 200);
    }

    


}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
<<<<<<< HEAD
=======
use App\Mail\SignupEmailVerifcation;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use App\Models\Page;
use App\Models\Pageanalytics;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Mail;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use Illuminate\Validation\Rules;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json(new UserResource(auth()->user()), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function userNameValid(Request $request): Response
    {
        
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            ]);

            return response('available', 200);
        
    }
    public function store(Request $request): Response
    {
        
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

<<<<<<< HEAD
=======
        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'image' => '/user-placeholder.png',
                'password' => Hash::make($request->password),
                'emailverification_code' => sha1(time()),
            ]);
    
            if ($user != null) {
                //send mail
                Mail::to($user->email)->send(new SignupEmailVerifcation($user->emailverification_code));
                event(new Registered($user));
                return response('Verification code sent', 200);
            }
            Auth::login($user);
    
            return response('success', 200);
           
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        
    }
    public function emailverification(Request $request): Response
    {
        
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'image' => '/user-placeholder.png',
            'password' => Hash::make($request->password),
<<<<<<< HEAD
        ]);

        event(new Registered($user));
=======
            'emailverification_code' => sha1(time()),
        ]);

        if ($user != null) {
            //send mail
            Mail::to($user->email)->send(new SignupEmailVerifcation($user->emailverification_code));
            event(new Registered($user));
            return response('Verification code sent', 200);
        }

        
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|max:25',
            'bio' => 'sometimes|max:80',
<<<<<<< HEAD
            'userCategory' => 'nullable|max:80',
=======
            //'userCategory' => 'nullable|max:80',
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        ]);

        try {
            if ($request->input('userCategory'))
            {
                $user->creator_category = $request->input('userCategory');
            }
            
            $user->username = $request->input('username');
            $user->bio = $request->input('bio');
            
            $user->save();

            return response()->json('USER DETAILS UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
<<<<<<< HEAD
=======
use App\Mail\SignupEmailVerifcation;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use App\Models\Page;
use App\Models\Pageanalytics;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Mail;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * login.
     */
    public function login(LoginRequest $request)
    {
        try {
            /* @var \App\Models\User $user */
            $credentials = $request->validated();

    
            $remember = $credentials['remember'] ?? false;
            unset($credentials['remember']);
            if (!Auth::attempt($credentials, $remember)) {
                return response([
                    'error' => 'the provided credentials are incorrect'
                ], 422);
            }
            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;
            return response([
                'user' => $user,
                'token' => $token
            ]);
           

        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage()
            ], 422);
            
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

<<<<<<< HEAD
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'image' => '/user-placeholder.png',
            'password' => Hash::make($request->password),
        ]);

        //create token for the user
        $token =$user->createToken('main')->plainTextToken;
    

        event(new Registered($user));

        //Auth::login($user);

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

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
        //return response('success', 200);
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
                $data = [
                    'username' => $user->username,
                    'emailverification_code' => $user->emailverification_code,
                    
                ];
                Mail::to($user->email)->send(new SignupEmailVerifcation($data));
                event(new Registered($user));
                return response(['message' =>'Verification code sent', 'email' => $user->email], 200);
            } else {
                return response()->json(['user not created'], 400);
            }
    
            
           
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

       
    }
    /**
     * Store a newly created resource in storage.
     */
    public function verifyemail(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
            
        ]);

        try {
            $user = User::where(['emailverification_code' => $request->input('code')])->first();
            if ($user != null) {
                
                $user->is_email_verified = true;
                $user->save();
                //$user = Auth::user();
                $token = $user->createToken('main')->plainTextToken;
                //start analytics
                $currentDate = Carbon::now();
                $previousDate = Carbon::now()->subDay();

                $pageanalytics = Pageanalytics::where('user_id', $user->id)
                    ->where('date', $previousDate->toDateString())
                    ->first();

                if (!$pageanalytics) {
                    Pageanalytics::create([
                        'user_id' => $user->id,
                        'date' => $previousDate->toDateString(),

                        // Fill other fields with empty values if needed
                    ]);
                }

                Pageanalytics::create([
                    'user_id' => $user->id,
                    'date' => $currentDate->toDateString(),

                    // Fill other fields for the current date
                ]);
            
                return response([
                    'user' => $user,
                    'token' => $token
                ], 200);
            } else {
                return response()->json('error invalid request', 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
<<<<<<< HEAD
    public function edit(User $user)
    {
        //
=======
    public function updateUsername(Request $request, User $user)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        $user->username = $request->input('username');
        $updateduser = $user->update();
        return response([
            'user' => $updateduser,
        ]);
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
<<<<<<< HEAD
    public function destroy(User $user)
=======
    public function logout(User $user)
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    {
        /* @var User $user */
        $user = Auth::user();
        $user->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
}

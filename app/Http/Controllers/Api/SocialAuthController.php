<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Pageanalytics;
use App\Models\User;
use Carbon\Carbon;
use Google\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    //
    public function redirectToProvider()
    {
        
        /**
         * Create google client
         */
        $client = $this->getClient();

        /**
         * Generate the url at google we redirect to
         */
        $authUrl = $client->createAuthUrl();

        /**
         * HTTP 200
         */
        return response()->json($authUrl, 200);
        
        
    }
    /**
     * obtain the user from google
     * 
     * @return \Illuminate\Http\Response
     */
    public function handlecallback(Request $request)
    {
        try{
            
                /**
                 * Get authcode from the query string
                 * Url decode if necessary
                 */
                //$authCode = $request->input('code');
                $authCode = $request->input('code');
            
                /**
                 * Google client
                 */
                $client = $this->getClient();
            
                /**
                 * Exchange auth code for access token
                 * Note: if we set 'access type' to 'force' and our access is 'offline', we get a refresh token. we want that.
                 */
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            
                /**
                 * Set the access token with google. nb json
                 */
                $client->setAccessToken(json_encode($accessToken));
            
                /**
                 * Get user's data from google
                 */
                $service = new \Google\Service\Oauth2($client);
                $userFromGoogle = $service->userinfo->get();
            
                /**
                 * Select user if already exists
                 */
                $user = User::where('authprovider', '=', 'google')
                    ->where('authprovider_id', '=', $userFromGoogle->id)
                    ->first();
            
                ///**
                // */
                if (!$user) {
                    //register
                    $user = User::create([
                            'authprovider' => 'google',
                            'authprovider_id' => $userFromGoogle->id,
                            //'google_access_token_json' => json_encode($accessToken),
                            'fullname' => $userFromGoogle->name,
                            'email' => $userFromGoogle->email,
                            'authprovider_emailverified' => $userFromGoogle->verifiedEmail,
                            //'avatar' => $providerUser->picture, // in case you have an avatar and want to use google's
                    ]);
                    //create token for the user
                    $token =$user->createToken('main')->plainTextToken;   
                    event(new Registered($user));

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
                        'user' => new UserResource($user),
                        'token' => $token
                    ], 200);
                } else {
                    //login
                    $user = Auth::user();
                    $token = $user->createToken('main')->plainTextToken;
                    return response([
                        'user' => $user,
                        'token' => $token
                    ]);
                }
            
                /**
                 * Log in and return token
                 * HTTP 201
                 */
                //$token = $user->createToken("Google")->accessToken;
                //return response()->json($token, 201);
                //return response()->json($userFromGoogle, 200);
            // postLogin
        } catch (\Exception $e) {
            Log::error($e);

            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Gets a google client
     *
     * @return \Google_Client
     * INCOMPLETE
     */
    private function getClient():\Google_Client
    {
         // create the client
         $client = new Client();
         $client->setApplicationName('creatorspage');
         $client->setAuthConfig(storage_path('loginwithgoogle.json'));
         $client->setAccessType('offline'); // necessary for getting the refresh token
         $client->setApprovalPrompt ('force'); // necessary for getting the refresh token
         // scopes determine what google endpoints we can access. keep it simple for now.
         $client->setScopes(
             [
                 \Google\Service\Oauth2::USERINFO_PROFILE,
                 \Google\Service\Oauth2::USERINFO_EMAIL,
                 \Google\Service\Oauth2::OPENID,
                // \Google\Service\Drive::DRIVE_METADATA_READONLY // allows reading of google drive metadata
             ]
         );
         $client->setIncludeGrantedScopes(true);
        return $client;
    } // getClient
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing;

class MailchimpAuthController extends Controller
{
    public function getAuthUrl(Request $request)
    {
        $mailchimpClientId = getenv('MAILCHIMP_CLIENT_ID');
        $mailchimpclientsecret = getenv('MAILCHIMP_CLIENT_SECRET');
        $base_url = getenv('FRONTEND_URL');
        $oauthCallback = "$base_url/app/settings";

        $queryParams = [
            'response_type' => 'code',
            'client_id' => $mailchimpClientId,
            'redirect_uri' => $oauthCallback,
        ];
    
        $oauthUri = 'https://login.mailchimp.com/oauth2/authorize?' . http_build_query($queryParams);
    
        return $oauthUri;

        //code=94915b0ab1bc27da49d2b809bfb6735b
    }

    public function getMailchimpAccessToken(Request $request)
    {
      try
        {
            $user = User::where('id', auth()->user()->id)->first();
            $mailchimp_client_id = getenv('MAILCHIMP_CLIENT_ID');
            //$mailchimp_client_id ='813762100402';
            //$mailchimp_client_secret = '684dfc37d2656a1b17fa91c35aa4ad9b4c0ba4c52d06daa2d8';
            $mailchimp_client_secret = getenv('MAILCHIMP_CLIENT_SECRET');
            $base_url = getenv('FRONTEND_URL');
            $oauth_callback = "http://127.0.0.1:3000/app/settings";
            $code = $request->input('code');
            //$code= '94915b0ab1bc27da49d2b809bfb6735b';


            $url = 'https://login.mailchimp.com/oauth2/token';
            $context = stream_context_create([
              'http' => [
                'header' => "Content-type:application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query([
                  'grant_type' => "authorization_code",
                  'client_id' => $mailchimp_client_id,
                  'client_secret' => $mailchimp_client_secret,
                  'redirect_uri' => $oauth_callback,
                  'code' => $code,
                ]),
              ],
            ]);
            $result = file_get_contents($url, false, $context);
            $decoded = json_decode($result);
            $access_token = $decoded->access_token;
            $user->mailchimpaccess_token = $access_token;
            $user->isMailchimpAuthorized = true;
            $user->save();

            $dc = $this->getServerPrefix($access_token, $user);

            //return response()->json(['mailchimpClientId' => $mailchimpClientId, 'mailchimpclientsecret' => $mailchimpclientsecret, 'code' => $code]);
            return response()->json(['access_token' => $result, 'dc' => $dc]);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error($e);

            return response()->json(['error' => $e], 500);
        }
        //code=9e4f343f51d622a6ab6fb2fac35d0d8d
    }


    public function saveSubscriber(Request $request)
    {
      $user = User::where('id', $data['user_id'])->first();
      $links = Link::where('id', $data['form_id'])->first();
      $list_id = $request->input('listid');
      $mailchimp = new \MailchimpMarketing\ApiClient();

      $mailchimp->setConfig([
        'accessToken' => 'YOUR_ACCESS_TOKEN',
        'server' => 'YOUR_SERVER_PREFIX'
      ]);

      $list_id = "YOUR_LIST_ID";

      try {
          $response = $mailchimp->lists->addListMember($list_id, [
              "email_address" => "prudence.mcvankab@example.com",
              "status" => "subscribed",
              "merge_fields" => [
                "FNAME" => "Prudence",
                "LNAME" => "McVankab"
              ]
          ]);
          return response()->json(['data' => $response], 500);
      } catch (MailchimpMarketing\ApiException $e) {
          //echo $e->getMessage();
          Log::error($e);
          return response()->json($e->getMessage(), 500);
      }
    }

    public function getServerPrefix($token, $user)
    {
        try
        {
            //$user = User::where('id', auth()->user()->id)->first();
            $access_token = $token;
            $url = 'https://login.mailchimp.com/oauth2/metadata';
            $context = stream_context_create([
              'http' => [
                'header' => "Authorization:OAuth $access_token",
              ],
            ]);
            $result = file_get_contents($url, false, $context);
            $decoded = json_decode($result);
            $dc = $decoded->dc;
            $user->mailchimp_dc = $dc;
            $user->save();

            return  $dc;
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error($e);

            return response()->json(['error' => 'Failed to retrieve Mailchimp  dc'], 500);
        }
    }
}

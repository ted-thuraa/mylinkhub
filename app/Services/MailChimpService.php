<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use MailchimpMarketing;

class MailChimpService
{
    protected $mailchimpClientId, $mailchimpclientsecret, $base_url, $oauthCallback, $user;

    public function __construct()
    {
        //client
        $this->mailchimpClientId = getenv('MAILCHIMP_CLIENT_ID');
        $this->mailchimpclientsecret = getenv('MAILCHIMP_CLIENT_SECRET');
        $this->base_url = getenv('FRONTEND_URL');
        $this->oauthCallback = "$this->base_url/app/settings";

        
    }

    public function getAuthUrl()
    {
        $queryParams = [
            'response_type' => 'code',
            'client_id' => $this->mailchimpClientId,
            'redirect_uri' => $this->oauthCallback,
        ];
    
        $oauthUri = 'https://login.mailchimp.com/oauth2/authorize?' . http_build_query($queryParams);
    
        return $oauthUri;
        //return $this->client->createAuthUrl();
    }
    public function getToken($callbackcode, $user_id)
    {
        try
        {
            $user = User::where('id', $user_id)->first();
           
            
            $url = 'https://login.mailchimp.com/oauth2/token';
            $context = stream_context_create([
              'http' => [
                'header' => "Content-type:application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query([
                  'grant_type' => "authorization_code",
                  'client_id' => $this->mailchimpClientId,
                  'client_secret' => $this->mailchimpclientsecret,
                  'redirect_uri' => $this->oauthCallback,
                  'code' => $callbackcode,
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
        
    }


    public function saveSubscriber($access_token, $server, $list_id, $contactemail, $contactname)
    {
      
      $mailchimp = new \MailchimpMarketing\ApiClient();

      $mailchimp->setConfig([
        'accessToken' => $access_token,
        'server' => $server,
      ]);

      

      try {
          $response = $mailchimp->lists->addListMember($list_id, [
              "email_address" => $contactemail,
              "status" => "subscribed",
              "merge_fields" => [
                "FNAME" => $contactname,
                "LNAME" => "",
              ]
          ]);
          return $response;
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
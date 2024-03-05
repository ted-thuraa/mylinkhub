<?php

namespace App\Services;

use Google\Client;
use Google_Service;
use Google\Service\Sheets;
use Google\Service\Sheets\Sheet;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class GoogleSheetService
{
    protected $client, $service, $sheetid, $range, $user;

    public function __construct($user, $docid)
    {
        //client
        $this->user = $user;
        $this->client = new Client();
        $this->client->setApplicationName('linkhub');
        $this->client->setScopes([Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(storage_path('credentials.json'));
        $this->client->setAccessType('offline');
        if ($this->user->googleaccess_token){
            
            $this->client->setAccessToken($this->user->googleaccess_token);
        }
        if ($this->client->isAccessTokenExpired()) {
            
            //refresh the token if possible else fetch a new one
            if ($this->user->googlerefresh_token) {
                
                $cred = $this->client->refreshToken($this->user->googlerefresh_token);
                $this->user->googleaccess_token = $cred['access_token'];

                
                $this->user->save();
            } else {
                //request fresh authorization
                return $this->client->createAuthUrl();
            }
        }

        //service
        $this->service = new Sheets($this->client);
        $this->sheetid = $docid;
        $this->range = 'A:Z';
        
        //if no previos token or its expired
        
    }

    public function getAuthUrl()
    {
        return $this->client->createAuthUrl();
    }
    public function getToken($authorization_code)
    {
        return $this->client->fetchAccessTokenWithAuthCode($authorization_code);
    }
    public function appendSheet($values)
    {
        $body = new ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];
        $result = $this->service->spreadsheets_values->append($this->sheetid, $this->range, $body, $params);
        return $result;
    }
   
}
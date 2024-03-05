<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserDataMailing;
use App\Models\FormAnalytics;
use App\Models\FormClicks;
use App\Models\FormResponces;
use App\Models\FormViews;
use App\Models\Link;
use App\Models\User;
use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;
use App\Services\GoogleSheetService;
use App\Services\MailChimpService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class GuestDataSubmitionController extends Controller
{
    public function getAuthUrl(Request $request)
    {
        

         try {
            $sheetId = null;
            $user = User::find($request->user()->id);
            $helper = (new GoogleSheetService($user, $sheetId))->getAuthUrl();
            return $helper;
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 400);
         }

        
    }
    public function setCode(Request $request)
    {
         

         try {
            $user = User::find($request->user()->id);
            $sheetId = null;
            $helper = (new GoogleSheetService( $user, $sheetId ))->getToken($request->input('code'));
            $user->googleaccess_token = $helper['access_token'];
            $user->googlerefresh_token = $helper['refresh_token'];
            $user->tokenexpires_in = $helper['expires_in'];
            $user->isgooglesheetsauthorized = true;
            $user->save();

             return response()->json(['data' => $helper], 200);
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 400);
         }

        //$helper = $request->input('code');
        //$requser = $request->user();
        

        
    }
    public function storeAnswers(Request $request)
    {
        $data = $request->validate([
            'uid' => 'required|exists:users,id',
            'form_id' => 'required|exists:links,id',
            'type' => 'required|string',
            'data' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_array($value) && !is_string($value)) {
                        $fail($attribute.' must be an array or a string.');
                    }
                },
            ],
            //'data' => 'nullable|array',
        ]);
    
        try
        {
            $ip = '207.113.125.164';
            //$ip = $request->ip();
            $user = User::where('id', $data['uid'])->first();
            $link = Link::where('id', $data['form_id'])->first();

            if (!$link) {
                return response()->json(['Form not found'], 404);
            }
            $res = null;

            switch ($link->responces_storage) {
                case "Email":
                    if (in_array($data['type'], ["Contact form", "Hire", "Feedback form"])) {
                        $res = $this->sendToEmail($data, $link, $user, $ip);
                    } else {
                        return response()->json(['We currently do not support sending custom forms to email addresses'], 403);
                    }
                    break;
                
                case "Googlesheets":
                    $res = $this->sendToGoogleSheets($data, $link, $user, $ip);
                    break;
                
                case "Mailchimp":
                    if (in_array($data['type'], ["Waiting List", "Mailing List"])) {
                        $res = $this->sendToMailChimp($data, $link, $user, $ip);
                    } else {
                        return response()->json(['We currently do not support sending custom forms to Mailchimp'], 403);
                    }
                    break;
                
                case null:
                    $res = $this->sendToMyDashboard($data, $link, $user, $ip);
                    break;
                
                default:
                    return response()->json(['Invalid response storage'], 400);
            }

            if ($res) {
                return response()->json($res, 200);
            } else {
                return response()->json(['error failed to send'], 500);
            }
            
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            //Log::error($e);

            return response()->json(['error' => $e], 500);
        }
        
    }


    private function saveCustomFormRespoces($data)
    {
        try
        {
            $sheetId = null;
            //$data['data'] = json_encode($data['data']);
            $outputArray = [];
            $answers = null;
            
            // Prepare headers (questions)
            $headers = array_map(function ($item) {
                return $item['question'];
            }, $data['data']);

            // Prepare answers
            $answers = array_map(function ($item) {
                return is_array($item['question_answers']) ? implode(', ', $item['question_answers']) : $item['question_answers'];
            }, $data['data']);
    
            $user = User::where('id', $data['uid'])->first();
            $links = Link::where('id', $data['form_id'])->first();

            if ($links->responces_storage === "Googlesheets") {
                if ($links->responces === 0) {
                    // Combine headers and answers
                    $output = [$headers, $answers];
                } elseif ($links->responces > 0) {
                    // Combine headers and answers
                    $output = [$answers];
                }
                $googlesheeturl = $links->google_sheets_url;
                $sheetId = $this->extractSheetIdFromUrl($googlesheeturl);
                $gSheetresult = (new GoogleSheetService( $user, $sheetId))->appendSheet($output);
                
            }

            $links->responces += 1;
            $links->update();
            return response()->json(['data' => $gSheetresult], 200);
           
            
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error($e);

            return response()->json(['error' => $e], 500);
        }
    }

    private function saveContactFormResponces($data)
    {
        try
        {
            $user = User::where('id', $data['uid'])->first();
            $links = Link::where('id', $data['form_id'])->first();
            if ($links->responces_storage === "Email") {
                $sendtoemail = $links->responces_email;
              // Create an instance of the UserDataMailing class
            //$email = new UserDataMailing($data);

            // Send the email using the Mail::send() method
            if (!$sendtoemail){
                return response()->json('no mail to send to', 500);
            }
            Mail::to($sendtoemail)->send(new UserDataMailing($data['data']));
  
                
            };
            return response()->json('good to go, mail sent' , 200);
            
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            //Log::error($e);

            return response()->json(['error' => $e], 500);
        }
    }

    private function saveMailingList($data)
    {
        try
        {
    
            $user = User::where('id', $data['uid'])->first();
            $links = Link::where('id', $data['form_id'])->first();

            if ($links->responces_storage === "Googlesheets") {
                $googlesheeturl = $links->google_sheets_url;
                $sheetId = $this->extractSheetIdFromUrl($googlesheeturl);
                $gSheetresult = (new GoogleSheetService( $user, $sheetId))->appendSheet();
                
            }

            if ($links->responces_storage === "Mailchimp") {
                
                $access_token = $user->mailchimpaccess_token;
                $server = $user->mailchimp_dc;
                $list_id = $links->mailchimplistid;
                //$list_id = '321e7bd312';
                $contactemail = $data['data'];
                $mailchimpres = (new MailChimpService())->saveSubscriber($access_token, $server, $list_id, $contactemail);
                
            }
            $links->responces += 1;
            $links->update();
            return response()->json(['data' => $mailchimpres], 200);
            
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error($e);

            return response()->json(['error' => $e], 500);
        }
    }


    


    private function sendToEmail($data, $link, $user, $ip)
    {
        $sendtoemail = $link->responces_email;
        if (!$sendtoemail) {
            return response()->json('No email to send to', 403);
        }
    
        $refined_data = [];
    
        switch ($data['type']) {
            case "Contact form":
                $fieldMappings = [
                    'email' => 'email',
                    'name' => 'name',
                    'phone' => 'phone',
                    'country' => 'country',
                    'message' => 'message',
                ];
    
                foreach ($data['data'] as $item) {
                    $question = $item['question'];
    
                    if (isset($fieldMappings[$question])) {
                        $refined_data[$fieldMappings[$question]] = $item['question_answers'];
                    }
                }
                break;
    
            case "Hire":
                // Handle "Hire" type data
                break;
    
            case "Feedback form":
            
                // Handle "Feedback form" and "Waiting List" type data
                break;
    
            default:
                return response()->json('Invalid data type', 400);
        }
        
        // Check if an email address is valid
        if (filter_var($refined_data['email'], FILTER_VALIDATE_EMAIL)) {
            Mail::to($sendtoemail)->send(new UserDataMailing($refined_data));
            
            FormResponces::create([
                'link_id' => $link->id,
                'form_type' => $data['type'],
                'sent_to' => $link->responces_storage,
                'ip' => $ip,
            ]);
            $date = now()->toDateString();
            $formview = FormViews::where('link_id', $link->id)->where('ip', $ip)->first();
            $uniquevisitor = $formview ? 0 : 1;

            // Update analytics
             $views = FormViews::where('link_id', $link->id)->count();
             $clicks = FormClicks::where('link_id', $link->id)->count();
             $responces = FormResponces::where('link_id', $link->id)->count();
             $ctr = $views > 0 && $clicks > 0 ? round(($clicks / $views) * 100, 2) : 0;
             $conversion_rate = $clicks > 0 && $responces > 0 ? round(($clicks / $responces) * 100, 2) : 0;
         
             // Now you can use $ctr as needed
             $formanalytics = FormAnalytics::firstOrNew(['link_id' => $link->id, 'date' => $date]);
             //$formanalytics->date = $date;
             $formanalytics->views += $views;
             $formanalytics->clicks = $clicks;
             $formanalytics->ctr = $ctr;
             $formanalytics->conversion_rate = $conversion_rate;
             $formanalytics->uniqueviews += $uniquevisitor;
             $formanalytics->save();
             $uniquevisitor = 0;

            
            return response()->json('Success, mail sent', 200);
        } else {
            return response()->json('Invalid email address', 400);
        }
        
    }
    private function sendToMailChimp($data, $link, $user, $ip)
    {
        $access_token = $user->mailchimpaccess_token;
        $server = $user->mailchimp_dc;
        $list_id = $link->mailchimplistid;
        $email = null;
        $name = null;

        foreach ($data as $item) {
            if ($item["question"] === 'email') {
                $email = $item["question_answers"];
            } elseif ($item["question"] === 'name') {
                $name = $item["question_answers"];
                
            };
        };

        $contactname =  $name;
        $contactemail =  $email;
        if ($contactemail !== null) {
            $mailchimpres = (new MailChimpService())->saveSubscriber($access_token, $server, $list_id, $contactemail, $contactname);
            FormResponces::create([
                'link_id' => $link->id,
                'form_type' => $data['type'],
                'sent_to' => $link->responces_storage,
                'ip' => $ip,
            ]);
            $date = now()->toDateString();
            $formview = FormViews::where('link_id', $link->id)->where('ip', $ip)->first();
            $uniquevisitor = $formview ? 0 : 1;

            // Update analytics
             $views = FormViews::where('link_id', $link->id)->count();
             $clicks = FormClicks::where('link_id', $link->id)->count();
             $responces = FormResponces::where('link_id', $link->id)->count();
             $ctr = $views > 0 && $clicks > 0 ? round(($clicks / $views) * 100, 2) : 0;
             $conversion_rate = $clicks > 0 && $responces > 0 ? round(($clicks / $responces) * 100, 2) : 0;
         
             // Now you can use $ctr as needed
             $formanalytics = FormAnalytics::firstOrNew(['link_id' => $link->id, 'date' => $date]);
             //$formanalytics->date = $date;
             $formanalytics->views += $views;
             $formanalytics->clicks = $clicks;
             $formanalytics->ctr = $ctr;
             $formanalytics->conversion_rate = $conversion_rate;
             $formanalytics->uniqueviews += $uniquevisitor;
             $formanalytics->save();
             $uniquevisitor = 0;
            return response()->json('Success,' , 200);
        } else {
            echo "Email address not found in the array.";
        }
        

        
    }

    private function sendToGoogleSheets($data, $link, $user, $ip)
    {
        $sheetId = null;
        //$data['data'] = json_encode($data['data']);
        $outputArray = [];
        $answers = null;
        
        // Prepare headers (questions)
        $headers = array_map(function ($item) {
            return $item['question'];
        }, $data['data']);
        // Prepare answers
        $answers = array_map(function ($item) {
            return is_array($item['question_answers']) ? implode(', ', $item['question_answers']) : $item['question_answers'];
        }, $data['data']);

        if ($link->google_sheets_submissions === 0) {
            // Combine headers and answers
            $output = [$headers, $answers];
        } elseif ($link->google_sheets_submissions > 0) {
            // Combine headers and answers
            $output = [$answers];
        }

        $googlesheeturl = $link->google_sheets_url;
        $sheetId = $this->extractSheetIdFromUrl($googlesheeturl);
        $gSheetresult = (new GoogleSheetService( $user, $sheetId))->appendSheet($output);

        
        $link->google_sheets_submissions += 1;
        $link->update();

        FormResponces::create([
            'link_id' => $link->id,
            'form_type' => $data['type'],
            'sent_to' => $link->responces_storage,
            'ip' => $ip,
        ]);
        $date = now()->toDateString();
        $formview = FormViews::where('link_id', $link->id)->where('ip', $ip)->first();
        $uniquevisitor = $formview ? 0 : 1;

        // Update analytics
         $views = FormViews::where('link_id', $link->id)->count();
         $clicks = FormClicks::where('link_id', $link->id)->count();
         $responces = FormResponces::where('link_id', $link->id)->count();
         $ctr = $views > 0 && $clicks > 0 ? round(($clicks / $views) * 100, 2) : 0;
         $conversion_rate = $clicks > 0 && $responces > 0 ? round(($clicks / $responces) * 100, 2) : 0;
     
         // Now you can use $ctr as needed
         $formanalytics = FormAnalytics::firstOrNew(['link_id' => $link->id, 'date' => $date]);
         //$formanalytics->date = $date;
         $formanalytics->views += $views;
         $formanalytics->clicks = $clicks;
         $formanalytics->ctr = $ctr;
         $formanalytics->conversion_rate = $conversion_rate;
         $formanalytics->uniqueviews += $uniquevisitor;
         $formanalytics->save();
         $uniquevisitor = 0;
        return response()->json(['data' => $gSheetresult], 200);

        
    }

    private function sendToMyDashboard($data, $link, $user, $ip)
    {
        try {
            // Your database operations here
            $answers = json_encode($data['data']);
        

            FormResponces::create([
                'link_id' => $link->id,
                'answer_data' => $answers,  
                'form_type' => $data['type'],   
                'sent_to' => 'Dashboard',   
                'ip' => $ip,    
            ]); 

            $date = now()->toDateString();  
            $formview = FormViews::where('link_id', $link->id)->where('ip', $ip)->first();
            $uniquevisitor = $formview ? 0 : 1; 
    
            // Update analytics
             $views = FormViews::where('link_id', $link->id)->count();
             $clicks = FormClicks::where('link_id', $link->id)->count();
             $responces = FormResponces::where('link_id', $link->id)->count();
             $ctr = $views > 0 && $clicks > 0 ? round(($clicks / $views) * 100, 2) : 0;
             $conversion_rate = $clicks > 0 && $responces > 0 ? round(($clicks / $responces) * 100, 2) : 0;
        
             // Now you can use $ctr as needed
             $formanalytics = FormAnalytics::firstOrNew(['link_id' => $link->id, 'date' => $date]);
             //$formanalytics->date = $date;
             $formanalytics->views += $views;
             $formanalytics->clicks = $clicks;
             $formanalytics->ctr = $ctr;
             $formanalytics->responces = $responces;
             $formanalytics->conversion_rate = $conversion_rate;
             $formanalytics->uniqueviews += $uniquevisitor;
             $formanalytics->save();
             $uniquevisitor = 0;
            return response()->json([$formanalytics], 200);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e->getMessage());
        }
        

        
    }

    private function extractSheetIdFromUrl($url)
    {
        $matches = [];
        preg_match('/^https:\/\/docs\.google\.com\/spreadsheets\/d\/([a-zA-Z0-9_-]+)/', $url, $matches);
        return $matches[1] ?? null;
    }
    
}

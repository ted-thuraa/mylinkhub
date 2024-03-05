<?php

namespace App\Http\Controllers\Api;

<<<<<<< HEAD
use App\Http\Controllers\Controller;
use App\Http\Resources\LinksCollection;
use App\Http\Resources\MainLinkAnalyticsResource;
=======
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Formanalytics;
use App\Http\Resources\FormResponceCollection;
use App\Http\Resources\Linkanalytics;
use App\Http\Resources\LinksCollection;
use App\Http\Resources\MainLinkAnalyticsResource;
use App\Models\FormResponces;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use App\Models\Link;
use App\Models\Mainlinkanalytics;
use App\Models\Page;
use App\Models\Pageanalytics;
<<<<<<< HEAD
use App\Models\User;
use Illuminate\Http\Request;
=======
use App\Models\Pageviews;
use App\Models\User;
use Google\Service\Analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

class AnalyticsDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function fetchdata(Request $request)
    {
        $username = $request->input('username');
        try {
            
<<<<<<< HEAD
            $page = Page::where('user_id', auth()->user()->id)->first();
            $analytics = Pageanalytics::where('page_id', $page->id)->get();
            return MainLinkAnalyticsResource::collection($analytics);
=======
            $user = User::where('id', auth()->user()->id)->first();
            $analytics = Pageanalytics::where('user_id', $user->id)->get();
            $pageviews = Pageviews::where('user_id', $user->id)->count();
            
            return response()->json(['total_views' => $pageviews, 'analytics' => MainLinkAnalyticsResource::collection($analytics)], 200);
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * Display a fetch links data.
     */
    public function fetchlinksdata(Request $request)
    {
<<<<<<< HEAD
        $username = $request->input('username');
        try {
          
            $page = Page::where('user_id', auth()->user()->id)->first();
            $links = Link::where('page_id', $page->id)->orderBy('clicks', 'desc')->get();
            
            
            return response()->json(new LinksCollection($links), 200);
=======
       
        try {
          
            $user = User::where('id', auth()->user()->id)->first();

            $links = Link::where('user_id', $user->id)
                ->where(function ($query) {
                    $query->where('category', 'link')
                          ->orWhere('category', 'SaaS');
                })
                ->withCount(['clicks as total_clicks' => function ($query) {
                    $query->select(DB::raw('count(*)'))
                          ->from('form_clicks')
                          ->whereColumn('link_id', 'links.id');
                }])
                ->get();

                // Calculate the total clicks for all links
                $totalClicks = $links->sum('total_clicks');

                // Calculate the percentage of clicks for each link
                foreach ($links as $link) {
                    $link->click_percentage = ($totalClicks > 0) ? ($link->total_clicks / $totalClicks) * 100 : 0;
                }
            
            
            return response()->json(new Linkanalytics($links), 200);
            //return response()->json($links, 200);
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
<<<<<<< HEAD
=======
    public function fetchformsdata(Request $request)
    {
       
        try {
          
            $user = User::where('id', auth()->user()->id)->first();
            //$links = Link::where('page_id', $page->id)->orderBy('clicks', 'desc')->get();
            // $links = Link::where('user_id', $user->id)
            // ->where('category', 'Form')
            // ->orderBy('responces', 'desc')
            // ->get();
            $links = Link::where('id', $request->input('form_id'))->first();


            
            // $responces = FormResponces::where('link_id', $user->id)
            // ->where('category', 'Form')
            // ->orderBy('responces', 'desc')
            // ->get();
            
            
            //return response()->json(new Formanalytics($links), 200);
            //$datacollection =  new FormResponceCollection($links);
            //$links->data = json_decode($links->data);
            $data =  $links;
            //$formsOverview =  $this->refineCollection($data);
            //$responces =  ;
            $res = null;
            //Log::info($data);
            $summaryData = [];
            $customFormQuestions = [];
            $responces = [];
            $responcesanswers = [];

            

            // Loop through each form
             
                //  $formName = $form['name'];
                //  $customFormQuestions = $form['form']['customformquestions'];
                //  $responces = $form['submissions'];

                $formName = $links->name;
                $formdata = json_decode($links->data);
                $customFormQuestions = $formdata->customformquestions;

                $responces = FormResponces::where('link_id',  $links->id)->get();
                $questionsItem = json_decode($responces[0]['answer_data'], true);

                // Extract questions and answers
                
                $questions = [];
                $answers = [];

                foreach ($questionsItem as $item) {
                    $questions[] = $item['question'];
                }

                // foreach ($responces as $res) {
                //     $ip = $res['ip'];

                //     // Format the date
                //     $date = date('j M Y', strtotime($res['created_at']));
                //     foreach (json_decode($res['answer_data']) as $answer) {
                //         if (is_array($answer->question_answers)) {
                //             $answers[] = [implode(', ', $answer->question_answers)];
                //         } else {
                //             $answers[] = [$answer->question_answers];
                //         }
                //     }
                // }
                
                // $result = [
                //     'ip' => $ip,
                //     'date' => $date,
                //     'questions' => $questions,
                //     'answers' => $answers,
                // ];
                
                $totalResponses = $responces->count();

                // Initialize an array to store the summary data for this form
                $formSummary = [];
                


                if ($formdata->formtype == 'Custom') {
                    // Loop through each question in the form
                     foreach ($customFormQuestions as $question) {
                             $questionId = $question->id;
                             $questionText = $question->question;
                             $questionType = $question->type;
                            
                             // Initialize counters
                             
                             $totalOptionrescount = 0;
                             $nullResponses = 0;
                             $optionCounts = [];
                             $questionArray = [];
                             $options = [];
                             $ip = null;
                             $date = null;
                             $ans = null;
                             $answer_res = [];


                            
                             // Loop through submissions to analyze responses to this question
                               foreach ($responces as $submission) {
                                
                                  $responcesanswers[] = json_decode($submission);
                                 
                                   foreach (json_decode($submission->answer_data) as $answer) {
                                    $responcesanswers[] = json_decode($submission->answer_data);
                                       if ($answer->question === $questionText) {                                    
                                           // Check if the answer is null
                                           if ($answer->question_answers === null) {
                                               $nullResponses++;
                                           } else {
                                            if ($questionType === 'radio' || $questionType === 'checkbox') {
                                               // For radio and checkbox questions, count option selections
                                               $options = $question->data->options;
                                               $selectedOptions = is_array($answer->question_answers)
                                                   ? $answer->question_answers
                                                   : [$answer->question_answers];

                                                
                                        
                                               

                                                foreach ($selectedOptions as $selectedOption) {
                                                    if (!isset($optionCounts[$selectedOption])) {
                                                        $optionCounts[$selectedOption] = 1;
                                                        $totalOptionrescount++;
                                                    } else {
                                                        $optionCounts[$selectedOption]++;
                                                        $totalOptionrescount++;
                                                    }
                                                }

                                                foreach ($question->data->options as $questionoption) {
                                                    if (!isset($optionCounts[$questionoption->text])) {
                                                        $optionCounts[$questionoption->text] = 0;
                                                    }     
                                                }
                                           }
                                        }
                                      }
                                   }
                                   $answers_raw = json_decode($submission->answer_data);
                                   $output = [];
                                   foreach ($answers_raw as $answer) {
                                    $output[] = [
                                        'question_answers' => is_array($answer->question_answers) ? implode(', ', $answer->question_answers) : $answer->question_answers,
                                    ];
                                }
                                   $answer_res[] = [
                                    'ip' => $submission->ip,
                                    'date' => date('j M Y', strtotime($submission->created_at)),
                                    'ans' => $output,
                                  ];
                                  
                                   
                                   
                              }
                              $answers = $answer_res;
                
                         // Calculate percentages
                             $nullResponsePercentage = ($totalResponses > 0) ? ($nullResponses / $totalResponses) * 100 : 0;
                             $optionPercentages = [];

                             foreach ($optionCounts as $option => $count) {
                                 $optionPercentage = ($totalOptionrescount > 0) ? ($count / $totalOptionrescount) * 100 : 0;
                                 $optionPercentages[$option] = $optionPercentage;
                             }

                             // Store the summary data for this question
                             $formSummary[] = [
                                 //'question_id' => $questionId,
                                 'question_text' => $questionText,
                                 'question_type' => $questionType,
                                 'total_responses' => $totalResponses,
                                 'null_responses' => $nullResponses,
                                 'total_questionRespondents' => ($totalResponses - $nullResponses),
                                 'option_percentages' => $optionPercentages,
                                 'option_counts' => $optionCounts,
                                 'totalOptionrescount' => $totalOptionrescount,
                                 
                             ];

                        
                     }
            
                    // // Store the summary data for this form
                    /// $summaryData[] = [
                    ///     'form_name' => $formName,
                    ///     'form_summary' => $formSummary,
                    /// ];

                     $myObject = new \stdClass();
                     $myObject->form_name = $formName;
                     $myObject->form_summary = $formSummary;
                }
                     
            return response()->json([ 'summaryData' => $myObject, 'questions' => $questions, 'responcesanswers' => $answers ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    
    }
    public function formsOverviewdata(Request $request)
    {
       
        try {
          
            $user = User::where('id', auth()->user()->id)->first();
            //$links = Link::where('page_id', $page->id)->orderBy('clicks', 'desc')->get();
            $links = Link::where('user_id', $user->id)
            ->where('category', 'Form')
            ->with(['formanalytics' => function ($query) {
                $query->orderBy('date', 'asc'); // Order by date in ascending order
            }])
            ->get();

            
                 
            return response()->json($links, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    /**
     * Display a fetch links data.
     */
    public function fetchcountriesdata(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->first();
        $countryData = DB::table('pagevisitorlocationdatas')
        ->select('countryCode as id', DB::raw('COUNT(*) as value'))
        ->where('user_id', $user->id)
        ->groupBy('countryCode')
        ->orderBy('countryCode')
        ->get();

    

    return response()->json($countryData);
    }


    private function refineCollection($datacollection)
    {
        $totalResponses = 0;

        foreach ($datacollection as $item) {
            $totalResponses += $item['responces'];
        }
        //$totalResponses = array_sum(array_column($datacollection, 'responses'));

        $result = [];

        foreach ($datacollection as $item) {
            $percentage = ($totalResponses > 0) ? ($item['responces'] / $totalResponses) * 100 : 0;
            $item['percentage'] = $percentage . '%';
        
            $data = [
                'responces' => $item['responces'],
                'name' => $item['name'],
                'percentage' => $item['percentage'],
            ];
        
            $result[] = $data;
        }

        $response = ["result" => $result];

        // Return the result as JSON
        return $result;
    }

    private function customFormSummary($form, $answers)
    {
        // Initialize an array to store the summary data
        $summaryData = [];

        // Loop through each question in the custom form
        foreach ($form as $question) {
            $questionId = $question['id'];
            $questionText = $question['question'];
            $questionType = $question['type'];
        
            // Initialize counters
            $totalResponses = 0;
            $nullResponses = 0;
            $optionCounts = [];
        
            // Loop through submissions to analyze responses to this question
            foreach ($answers as $submission) {
                foreach ($submission['answerdata'] as $answer) {
                    if ($answer['question'] === $questionText) {
                        $totalResponses++;
                    
                        // Check if the answer is null
                        if ($answer['question_answers'] === null) {
                            $nullResponses++;
                        } elseif ($questionType === 'radio' || $questionType === 'checkbox') {
                            // For radio and checkbox questions, count option selections
                            $selectedOptions = is_array($answer['question_answers'])
                                ? $answer['question_answers']
                                : [$answer['question_answers']];
                        
                            foreach ($selectedOptions as $selectedOption) {
                                if (!isset($optionCounts[$selectedOption])) {
                                    $optionCounts[$selectedOption] = 1;
                                } else {
                                    $optionCounts[$selectedOption]++;
                                }
                            }
                        }
                    }
                }
            }
        
            // Calculate percentages
            $nullResponsePercentage = ($nullResponses / $totalResponses) * 100;
            $optionPercentages = [];
        
            foreach ($optionCounts as $option => $count) {
                $optionPercentage = ($count / $totalResponses) * 100;
                $optionPercentages[$option] = $optionPercentage;
            }
        
            // Store the summary data for this question
            $summaryData[] = [
                'question_id' => $questionId,
                'question_text' => $questionText,
                'question_type' => $questionType,
                'total_responses' => $totalResponses,
                'null_response_percentage' => $nullResponsePercentage,
                'option_percentages' => $optionPercentages,
                'option_counts' => $optionCounts,
            ];
        }
        return $summaryData;
    }
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
}

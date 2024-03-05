<?php

namespace App\Http\Controllers\Api;

<<<<<<< HEAD
use App\Http\Controllers\Controller;
use App\Http\Resources\LinksCollection;
use App\Models\ContactFormData;
=======
use Embed\Embed;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\LinksCollection;
use App\Models\ContactFormData;
use App\Models\EcomData;
use App\Models\FormAnalytics;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
use App\Models\Link;
use App\Models\Page;
use App\Models\PortfolioData;
use App\Models\SaasData;
<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use App\Models\TextData;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Sunra\PhpSimple\HtmlDomParser;
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
<<<<<<< HEAD
            $page = Page::where('user_id', auth()->user()->id)->first();
            $links = Link::where('page_id', $page->id)->get();
=======
            $user = User::where('id', auth()->user()->id)->first();
            $links = Link::where('user_id', $user->id)->orderBy('order', 'asc')->get();
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
            //return LinksCollection::collection(Link::where('page_id', $page->id)->where('category', "other"));
            return response()->json(new LinksCollection($links), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
<<<<<<< HEAD
    /**
     * Display a listing of the resource.
     */
    public function fetchSocialLinks()
    {
        try {
            $page = Page::where('user_id', auth()->user()->id)->first();
            $links = Link::where('page_id', $page->id)->where('category', "social")->get();
            return response()->json(new LinksCollection($links), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
=======
    
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
        $request->validate([
            //'name' => 'required|max:20',
            'url' => 'nullable|active_url',
            'category' => 'required|max:20',
        ]);

        try {
            $title = null;
            if ($request->input('url')){

                $title = $this->getTitleFromLink($request->input('url'));
            }

            $page = Page::where('user_id', auth()->user()->id)->first();

            $link = new Link;

            $link->page_id = $page->id;
            $link->name = $title;
            $link->url = $request->input('url');
            $link->category = $request->input('category');
            // $link->image = '/link-placeholder.png';

            $link->save();

            SaasData::create([
                'link_id' => $link->id,
                // Fill other fields with empty values if needed
            ]);
            ContactFormData::create([
                'link_id' => $link->id,
                // Fill other fields with empty values if needed
            ]);
            PortfolioData::create([
                'link_id' => $link->id,
                // Fill other fields with empty values if needed
            ]);

            //return response($title);
            return response()->json('Link created', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
=======
        $user = User::where('id', auth()->user()->id)->first();
        $request->merge([
            'user_id' => $user->id
        ]);

        $data = $request->validate([
            'user_id' => 'exists:users,id',
            'url' => 'nullable|active_url',
            'faviconurl' => 'nullable',
            'thumbnailurl' => 'nullable',
            'category' => 'required|max:20',
            'name' => 'nullable',
            'redirect_link' => 'nullable',
            'description' => 'nullable',
            'active' => 'nullable',
            'clicks' => 'nullable',
            'icon' => 'nullable',
            'thumbnailimage' => 'nullable',
            'layout' => 'nullable',
            'data' => 'nullable',
            'bg_color' => 'nullable',
            'text_color' => 'nullable',
            'btn_color' => 'nullable',
        ]);

        try {
            $embed = new Embed();
            $scrapedData = null;
            // Set the 'name' field to the URL's title if 'url' is provided
             if ($request->input('url')) {
                 //$data['name'] = $this->getTitleFromLink($request->input('url'));
                 // Use caching to avoid making repeated requests for the same URL
                 $info = $embed->get($request->input('url'));
                 if ($data['category'] === 'SaaS') {
                    // Parse the URL
                    $parsedUrl = parse_url($request->input('url'));

                    // Extract the host (domain) part
                    $host = $parsedUrl['host'] ?? '';

                    // Remove 'www.' if it exists
                    $host = Str::replaceFirst('www.', '', $host);

                    // Extract the site name (first part of the host)
                    $siteName = explode('.', $host)[0];

                    // Capitalize the first letter of each word in the site name
                    $formattedSiteName = ucwords($siteName);
                    $data['name'] = $formattedSiteName;
                    $data['faviconurl'] = $info->favicon;
                    $data['thumbnailurl'] = $info->image;
                    //$data['description'] = $info->description;
                    $data['description'] = $info->description ?? $info->title;
                 } else {
                     //Get content info
                     $data['faviconurl'] = $info->favicon;
                     $data['thumbnailurl'] = $info->image;
                     $data['name'] = $info->title;
                     $data['description'] = $info->description;
                 }
            };
            $data['data'] = json_encode($data['data']);
            
            $link = Link::create($data);

            $currentDate = Carbon::now();
            $previousDate = Carbon::now()->subDay();

            $formAnalytics = FormAnalytics::where('link_id', $link->id)
            ->where('date', $previousDate->toDateString())
            ->first();
        
            if (!$formAnalytics) {
                FormAnalytics::create([
                    'link_id' => $link->id,
                    'date' => $previousDate->toDateString(),

                    // Fill other fields with empty values if needed
                ]);
            }

            FormAnalytics::create([
                'link_id' => $link->id,
                'date' => $currentDate->toDateString(),

                // Fill other fields for the current date
            ]);

            // FormAnalytics::create([
            //     'link_id' => $link->id,
            //     'date' => $previousDate->toDateString(),
                
            //     // Fill other fields with empty values if needed
            // ]);

            // FormAnalytics::create([
            //     'link_id' => $link->id,
            //     'date' => $currentDate->toDateString(),
                
            //     // Fill other fields for the current date
            // ]);
    

            return response()->json('Link created', 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
<<<<<<< HEAD
        $request->validate([
            'name' => 'required|max:18',
            'description' => 'nullable',
            'url' => 'required',
        ]);

        try {
            $link->name = $request->input('name');
            $link->description = $request->input('description');
            $link->url = $request->input('url');
            //$link->category = $request->input('category');
            $link->save();
=======
       
        $data = $request->validate([
            'url' => 'nullable|active_url',
            'faviconurl' => 'nullable',
            'thumbnailurl' => 'nullable',
            'category' => 'nullable|max:60',
            'name' => 'nullable',
            'redirect_link' => 'nullable',
            'description' => 'nullable',
            'active' => 'nullable',
            'icon' => 'nullable',
            'thumbnailimage' => 'nullable',
            'layout' => 'nullable',
            'data' => 'nullable',
            
        ]);

        try {
            if ($data['url']) {
                $embed = new Embed();
                $scrapedData = null;
                // Set the 'name' field to the URL's title if 'url' is provided
                 if ($request->input('url')) {
                     //$data['name'] = $this->getTitleFromLink($request->input('url'));
                     // Use caching to avoid making repeated requests for the same URL
                     $info = $embed->get($request->input('url'));
                     if ($request->input('category') === 'SaaS') {
                        // Parse the URL
                        $parsedUrl = parse_url($request->input('url'));

                        // Extract the host (domain) part
                        $host = $parsedUrl['host'] ?? '';

                        // Remove 'www.' if it exists
                        $host = Str::replaceFirst('www.', '', $host);

                        // Extract the site name (first part of the host)
                        $siteName = explode('.', $host)[0];

                        // Capitalize the first letter of each word in the site name
                        $formattedSiteName = ucwords($siteName);
                        $data['name'] = $formattedSiteName;
                        $data['faviconurl'] = $info->favicon;
                        $data['thumbnailurl'] = $info->image;
                        //$data['description'] = $info->description;
                        $data['description'] = ($info->description) ? $info->description : $info->title;
                     } else {
                         //Get content info
                         $data['faviconurl'] = $info->favicon;
                         $data['thumbnailurl'] = $info->image;
                         $data['name'] = $info->title;
                         $data['description'] = $info->description;
                     }
                };
            }
            //$link->name = $request->input('name');
            //$link->description = $request->input('description');
            //$link->url = $request->input('url');
            //$link->layout = $request->input('layout');
            //$link->active = $request->input('active');
            //$link->category = $request->input('category');
            $link->update($data);
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

            return response()->json('LINK DETAILS UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

<<<<<<< HEAD
=======
   


>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        try {
            if (
                !is_null($link->image)
                && file_exists(public_path() . $link->image
                && $link->image != '/user-placeholder.png'
                && $link->image != '/link-placeholder.png'
            )) {
                unlink(public_path() . $link->image);
            }
            $link->delete();

            return response()->json('LINK DETAILS DELETEED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
<<<<<<< HEAD


    private function getTitleFromLink($link)
    {
        // Use any suitable method to fetch the title from the provided link
        // For example, you can use an HTTP client or a regular expression to extract the title from the HTML
        // For this example, we'll use the file_get_contents() function and a regular expression
        $html = file_get_contents($link);
        preg_match('/<title[^>]*>(.*?)<\/title>/ims', $html, $matches);

        if (isset($matches[1])) {
            return $matches[1];
        }

        return null;
    }
}
=======
}



>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

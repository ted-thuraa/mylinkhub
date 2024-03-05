<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactFormData;
use App\Models\Link;
use App\Models\PortfolioData;
use App\Models\SaasData;
use App\Models\TextData;
use Illuminate\Http\Request;

class LinkDataController extends Controller
{
    public function layout(Request $request, Link $link)
    {
        $request->validate([
            'link_id' => 'required',
            'Layout' => 'nullable',
            
        ]);

        try {
            $link = Link::where('id', $request->input('link_id'))->first();
            $link->layout = $request->input('Layout');
            
            $link->save();

            return response()->json('LINK Layout UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function startupdata(Request $request, Link $link)
    {
        $data = $request->validate([
            'user_id' => 'exists:users,id',
            //'url' => 'nullable|active_url',
            'url' => 'nullable',
            'category' => 'required|max:20',
            //'name' => 'nullable',
            'redirect_link' => 'nullable',
            'description' => 'nullable',
            'active' => 'nullable',
            'clicks' => 'nullable',
            'icon' => 'nullable',
            'thumbnailimage' => 'nullable',
            'google_sheets_url' => 'nullable',
            'responces_email' => 'nullable',
            'layout' => 'nullable',
            'data' => 'nullable',
            'bg_color' => 'nullable',
            'text_color' => 'nullable',
            'btn_color' => 'nullable',
            
        ]);

        try {
            $data['data'] = json_encode($data['data']);
            
            $link = Link::where('id', $request->input('id'))->first();
            $link->update($data);
           
            // $saasdata->mrr = $request->input('currentmrr');
            // $saasdata->showmrr = $request->input('showcurrentmrr');
            // $saasdata->category = $request->input('category');
            // $saasdata->status = $request->input('status');
            // $saasdata->showstatus = $request->input('showstatus');
            
            // $saasdata->save();
            
            return response()->json('LINK saasdata UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
   
    public function formdata(Request $request, Link $link)
    {
        $data = $request->validate([
            'user_id' => 'exists:users,id',
            //'url' => 'nullable|active_url',
            //'url' => 'nullable',
            'category' => 'required|max:20',
            //'name' => 'nullable',
            //'redirect_link' => 'nullable',
            'description' => 'nullable',
            //'active' => 'nullable',
            //'clicks' => 'nullable',
            //'icon' => 'nullable',
            'google_sheets_url' => 'nullable',
            'mailchimplistid' => 'nullable',
            'responces_email' => 'nullable',
            'responces_storage' => 'nullable',
            'thumbnailimage' => 'nullable',
            'layout' => 'nullable',
            'data' => 'nullable',
            'bg_color' => 'nullable',
            'text_color' => 'nullable',
            'btn_color' => 'nullable',
        ]);

        try {
            $data['data'] = json_encode($data['data']);
            $link = Link::where('id', $request->input('id'))->first();
            $link->update($data);
            


            return response()->json('LINK formdata UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    
}

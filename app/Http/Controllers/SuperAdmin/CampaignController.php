<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaign::all();
        return view('superadmin.dashboard.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.dashboard.campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'name' => 'required|string|max:255',
            'objective' => 'required|string|max:255',
            'budget_type' => 'required|string|max:255',
            'budget' => 'required|numeric|min:10',
            'placement' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'schedule' => 'required|date',
            'start' => 'required',
            'end' => 'required',
            'bid_strategy' => 'required|string|max:255',
            'ad_name' => 'required|string|max:255',
            'ad_format' => 'required|string|max:255',
            'ad_media' => 'required',
        ]);
        $input = $request->all();
        if ($request->hasFile('ad_media')) {
            $video = $request->file('ad_media');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $videoPath = public_path() . '/uploads/ads/';
            $video->move($videoPath, $videoName);
            // $videoModel->video_path = '/uploads/ads/' . $videoName;

            $input['ad_media'] = '/uploads/ads/' . $videoName;
        }
        Campaign::create($input + ['remaining_budget' => $request->budget,'user_id'=>Auth::user()->id]);
        return redirect('super-admin/campaigns');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaign = Campaign::find($id);
        return view('superadmin.dashboard.campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $campaign = Campaign::find($id);
        return view('superadmin.dashboard.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'name' => 'required|string|max:255',
            'objective' => 'required|string|max:255',
            'budget_type' => 'required|string|max:255',
            'budget' => 'required|numeric|min:10',
            'placement' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'schedule' => 'required|date',
            'start' => 'required',
            'end' => 'required',
            'bid_strategy' => 'required|string|max:255',
            'ad_name' => 'required|string|max:255',
            'ad_format' => 'required|string|max:255',
        ]);

        $campaign = Campaign::find($id);
        $input = $request->all();
        if ($request->hasFile('ad_media')) {
            if ($campaign->ad_media != null && file_exists(public_path().$campaign->ad_media)) {
                unlink(public_path().$campaign->ad_media);
            }
            $video = $request->file('ad_media');
            $videoName = time() . '_' . Str::slug($video->getClientOriginalName()).'.'.$video->getClientOriginalExtension();
            $videoPath = public_path() . '/uploads/ads/';
            $video->move($videoPath, $videoName);
            // $videoModel->video_path = '/uploads/ads/' . $videoName;

            $input['ad_media'] = '/uploads/ads/' . $videoName;
        }
        $campaign->update($input);

        return redirect('super-admin/campaigns');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Campaign::destroy($id);
        return redirect('super-admin/campaigns');
    }
}

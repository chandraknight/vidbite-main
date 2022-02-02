<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AdStat;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    public function index()
    {
        return view('superadmin.dashboard.video.index');
    }

    public function playAd()
    {

        $user = auth()->user();
        $ad_stats = AdStat::first();



//        $q = Campaign::where(function($q) use($user) {
//                    return $q->where('age', $user->age_range())
//                        ->orWhere('age', 'All');
//             })
//            ->where(function($q) use($user) {
//
//                return $q->where('gender', $user->gender)
//                    ->orWhere('gender', 'All');
//            })
//            ->where(function($q) use($user) {
//
//                return $q->where('location', $user->location)
//                    ->orWhere('location', 'All');
//            })
//            ->where('schedule', '<=', Carbon::now()->toDateString())
//            ->where('start', '<=', Carbon::now()->toTimeString())
//            ->where('end', '>=', Carbon::now()->toTimeString())
//            ->where('status', 'Active');
//
//        if ($ad_stats) {
//            $q->where('bid_strategy', $ad_stats->bid_strategy);
//        }
//
//
//        $campaign = $q->orderBy('views')
//            ->first();

        $campaign  = Campaign::first();



        if ($campaign) {

            if (!$ad_stats) {

               $ad_stats= AdStat::create([
                    'bid_strategy' => $campaign->bid_strategy,
                    'played' => 0
                ]);
            }

            if ($ad_stats->bid_strategy == 'Lowest Cost') {

                if ($ad_stats->played == 1) {
                    $ad_stats->update(['bid_strategy' => 'Bid Cap', 'played' => 0]);
                } else {
                    $ad_stats->update(['played' => 1]);
                }

            } elseif ($ad_stats->bid_strategy == 'Bid Cap') {

                if ($ad_stats->played == 2) {
                    $ad_stats->update(['bid_strategy' => 'Lowest Cost', 'played' => 0]);
                } else {
                    $ad_stats->update(['played' => $ad_stats->played + 1]);
                }
            }

            $remaining_budget = $campaign->bid_strategy == 'Bid Cap'
                ? $campaign->budget - $campaign->bid
                : $campaign->budget - 1;

            $data = [
                'views' => $campaign->views + 1,
                'remaining_budget' => $remaining_budget
            ];

            if ($remaining_budget >= $campaign->budget) {
                $data + ['status' => 'Inactive'];
            }

            $campaign->update($data);

            return $campaign->ad_media;
        }

        if ($ad_stats) {
            $ad_stats->update([
                'bid_strategy' => $ad_stats->bid_strategy == 'Bid Cap'
                    ? 'Lowest Cost'
                    : 'Bid Cap', 'played' => 0
            ]);
        }

        return null;
    }
}

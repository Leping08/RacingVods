<?php

namespace App\Http\Controllers;

use App\Race;
use App\Season;
use App\Series;
use App\Track;
use App\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Race::orderBy('id', 'desc')->with(['track', 'season', 'series'])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $race = $request->validate([
            'name' => 'required|max:255',
            'series_id' => 'required|integer',
            'track_id' =>  'required|integer',
            'season_id' => 'required|integer',
            'race_date' => 'required|date',
            'youtube_id' => 'required|max:20',
            'youtube_start_time' => 'required|integer',
            'duration' => 'required|max:255'
        ]);

        $race['race_date'] = Carbon::parse($race['race_date']);

        $newRace = Race::create($race);
        Log::info("Race ID: $newRace->id was created. Name: $newRace->id");

        $video = Video::create([
            'youtube_id' => $request->youtube_id,
            'youtube_start_time' => $request->youtube_start_time,
            'race_id' => $newRace->id
        ]);
        Log::info("Video ID: $video->id was created and associated to Race ID: $newRace->id. Name: $newRace->id");

        return $newRace;
    }


    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function show($id)
    {
        return Race::with(['track', 'season', 'series', 'videos'])->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @return mixed
     */
    public function latest()
    {
        return Race::orderBy('id', 'desc')->take(5)->with(['track', 'season', 'series'])->get();
    }

    public function test()
    {
        $racesCount = Series::withCount('races')->pluck('races_count');
        $seriesNames = Series::pluck('name');

        return [
          'racesCount' => $racesCount,
          'seriesNames' => $seriesNames
        ];
    }

    public function test2()
    {
        $racesCount = Season::withCount('races')->pluck('races_count');
        $seasonNames = Season::withCount('races')->pluck('name');

        return [
            'racesCount' => $racesCount,
            'seasonNames' => $seasonNames
        ];
    }

    public function test3()
    {
        $racesCount = Track::withCount('races')->pluck('races_count');
        $trackNames = Track::withCount('races')->pluck('name');

        return [
            'racesCount' => $racesCount,
            'trackNames' => $trackNames
        ];
    }
}

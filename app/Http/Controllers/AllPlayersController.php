<?php

namespace App\Http\Controllers;

use App\Models\LanguageMaster;
use App\Models\League;
use App\Models\PlayerList;
use App\Models\PlayerMaster;
use App\Models\Season;
use Illuminate\Http\Request;

class AllPlayersController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Players';
        $languages = LanguageMaster::all();
        return view('admin.all_players.index', compact('pageTitle', 'languages'));
    }

    public function data()
    {
        $player_lists = PlayerMaster::where('default_language_post_id', 0)->get();
        $languages = LanguageMaster::all();
        
        return datatables()->of($player_lists)
        ->editColumn('league_id', function($player_list) {
            return $player_list->league ? $player_list->league->name : 'N/A';
        })
        ->editColumn('season_id', function($player_list) {
            return $player_list->season ? $player_list->season->name : 'N/A';
        })
        ->addColumn('languages', function ($player_list) use ($languages) {

            $buttons = '';
            foreach ($languages as $language) {

                $translation = PlayerMaster::where('language_id', $language->id)
                    ->where(function ($query) use ($player_list) {
                        $query->where('id', $player_list->id)
                            ->orWhere('default_language_post_id', $player_list->id);
                    })
                    ->first();

                if ($translation) {

                    // EDIT button
                    $url = route('admin.all-players.edit', [
                        'id' => $translation->id,
                        'language_id' => $language->id,
                        'default_language_post_id' => $translation->default_language_post_id,
                    ]);

                    $buttons .= '
                        <a href="'.$url.'" class="btn btn-sm btn-primary m-1">
                            <image src="'.asset('assets/images/edit-button.svg').'" 
                                 alt="'.$language->fullname.'" 
                                 title="'.$language->fullname.'"  style="width: 16px; height: 16px; display: inline-block;">
                        </a>
                    ';

                } else {

                    // ADD button
                    $url = route('admin.sub-all-players.add', [
                        'id' => $player_list->id,
                        'language_id' => $language->id,
                    ]);                       

                    $buttons .= '
                        <a href="'.$url.'" class="btn btn-sm btn-success m-1">
                             <image src="'.asset('assets/images/plus_symbol.svg').'" 
                                 alt="'.$language->fullname.'" 
                                 title="'.$language->fullname.'"  style="width: 16px; height: 16px; display: inline-block;">
                        </a>
                    ';
                }
            }

           

            return $buttons;
        })
        ->addColumn('action', function ($player_list) {
            $buttons = '
                <br>
                <a href="javascript:void(0)" 
                data-deleteid="'.$player_list->id.'"
                class="btn btn-sm btn-danger show-remove-modal">
                Delete All
                </a>
            ';
            return $buttons;
        })

        ->rawColumns(['languages', 'action'])
        ->make(true);
    }

    public function create()
    {
        $pageTitle = 'Create All Players';
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        return view('admin.all_players.create', compact('pageTitle', 'languages', 'leagues', 'seasons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'season_id'=> 'required',
            'league_id' => 'required',
            'language_id'=> 'required',
        ]);

        $player_master = PlayerMaster::create([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $request->language_id,
        ]);

        foreach ($request->players as $row)
        {
            if (empty($row['player_id']))
                continue;

            PlayerList::create([
                'player_master_id' => $player_master->id,
                'player_id' => $row['player_id'],
                'firstname' => $row['first_name'],
                'lastname' => $row['last_name'],
                'team_name'=> $row['team_name'],
                'matches' => $row['matches'],
                'goals_total' => $row['goals'],
                'assists' => $row['assists'],
                'player_image' => $row['player_image'],
                'team_image' => $row['team_image'],
                'positions' => $row['position'],
                'country' => $row['country'],
                'language_id' => $player_master->language_id
            ]);
        }

        return redirect()->route('admin.all-players.index')->with('success', 'All Players Created Successfully');
    }

    public function edit($id, $language_id, $default_language_post_id)
    {
        $player_master = PlayerMaster::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Edit '. $player_master->post_title .' - '.$language->fullname.' language';
        $player_list = PlayerList::where('player_master_id', $id)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        return view('admin.all_players.edit', compact('pageTitle', 'languages', 'leagues', 'seasons', 'player_master', 'player_list', 'language_id', 'default_language_post_id'));
    }

    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'season_id'=> 'required',
            'league_id' => 'required',
        ]);

        $player_master = PlayerMaster::findorfail($id);

        $player_master->update([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $language_id,
            'default_language_post_id' => $default_language_post_id
        ]);

        $savedIds = [];

        if($request->players)
        {
            foreach ($request->players as $row)
            {
                if (empty($row['player_id']))
                    continue;

                $record = PlayerList::updateOrCreate(
                    ['id' => $row['id'] ?? null],
                    [
                    'player_master_id' => $player_master->id,
                    'player_id' => $row['player_id'],
                    'firstname' => $row['first_name'],
                    'lastname' => $row['last_name'],
                    'team_name'=> $row['team_name'],
                    'matches' => $row['matches'],
                    'goals_total' => $row['goals'],
                    'assists' => $row['assists'],
                    'player_image' => $row['player_image'],
                    'team_image' => $row['team_image'],
                    'positions' => $row['position'],
                    'country' => $row['country'],
                    'language_id' => $language_id
                ]);

                $savedIds[] = $record->id;
            }
            // delete removed records
            PlayerList::where('player_master_id', $player_master->id)->whereNotIn('id', $savedIds)->delete();
        }

        return redirect()->route('admin.all-players.index')->with('success', 'All Players Updated Successfully');
    }

    public function addSubAllPlayers($id, $language_id)
    {
        $player_master = PlayerMaster::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Add All Players '. $player_master->post_title .' in  ('.$language->fullname.') language';
        $player_list = PlayerList::where('player_master_id', $id)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        return view('admin.all_players.add_sub', compact('pageTitle', 'languages', 'leagues', 'seasons', 'player_master', 'player_list', 'language_id'));
    }

    public function storeSubAllPlayers(Request $request, $id, $language_id)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'season_id'=> 'required',
            'league_id' => 'required'
        ]);

        $player_master = PlayerMaster::create([
            'post_title' => $request->post_title,
            'season_id' => $request->season_id,
            'league_id' => $request->league_id,
            'language_id' => $language_id,
            'default_language_post_id' => $id
        ]);

        foreach ($request->players as $row)
        {
            if (empty($row['player_id']))
                continue;

            PlayerList::create([
                'player_master_id' => $player_master->id,
                'player_id' => $row['player_id'],
                'firstname' => $row['first_name'],
                'lastname' => $row['last_name'],
                'team_name'=> $row['team_name'],
                'matches' => $row['matches'],
                'goals_total' => $row['goals'],
                'assists' => $row['assists'],
                'player_image' => $row['player_image'],
                'team_image' => $row['team_image'],
                'positions' => $row['position'],
                'country' => $row['country'],
                'language_id' => $language_id
            ]);
        }

        return redirect()->route('admin.all-players.index')->with('success', 'All Players Created Successfully');
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->deleteid;
            $allplayerListIds = PlayerMaster::where('id', $id)->orWhere('default_language_post_id', $id)->pluck('id');
            
            if ($allplayerListIds->isEmpty()) {
                return response()->json(['message' => 'No matches found'], 404);
            }

            PlayerList::whereIn('player_master_id', $allplayerListIds)->delete();

            PlayerMaster::whereIn('id', $allplayerListIds)->delete();

            return response()->json(['status' => true, 'message' => 'All Players deleted successfully']);
        }
        catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete All Players']);
        }
    }
}

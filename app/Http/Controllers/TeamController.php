<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\Season;
use App\Models\TeamPlayer;
use Illuminate\Http\Request;
use App\Models\LanguageMaster;
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    //

    public function index()
    {
        $pageTitle = 'Teams';
        $languages = LanguageMaster::all();
        return view('admin.team.index', compact('pageTitle', 'languages'));
    }

    public function data()
    {
        $teams = Team::where('default_language_post_id', 0)->get();
        $languages = LanguageMaster::all();
        
        return datatables()->of($teams)
        ->editColumn('league_id', function($team) {
            return $team->league ? $team->league->name : 'N/A';
        })
        ->editColumn('season_id', function($team) {
            return $team->season ? $team->season->name : 'N/A';
        })
        ->addColumn('languages', function ($team) use ($languages) {

            $buttons = '';
            foreach ($languages as $language) {

                $translation = Team::where('language_id', $language->id)
                    ->where(function ($query) use ($team) {
                        $query->where('id', $team->id)
                            ->orWhere('default_language_post_id', $team->id);
                    })
                    ->first();

                if ($translation) {

                    // EDIT button
                    $url = route('admin.teams.edit', [
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
                    $url = route('admin.sub-team.add', [
                        'id' => $team->id,
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
        ->addColumn('action', function ($team) {
            $buttons = '
                <br>
                <a href="javascript:void(0)" 
                data-deleteid="'.$team->id.'"
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
        $pageTitle = 'Create Team';
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        return view('admin.team.create', compact('pageTitle', 'leagues', 'seasons', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'league_id'=> 'required',
            'season_id'=> 'required',
            'language_id'=> 'required',
            'team_id'=> 'nullable|integer',
            'divanscore_home_id'=> 'nullable|integer',
            'divanscore_away_id'=> 'nullable|integer',
            'divanscore_tournament_id'=> 'nullable|integer',
            'divanscore_season_id'=> 'nullable|integer',
        ],
        [
            'post_title.required' => 'The team name field is required.',
        ] 
        );

        $teamPath = null;
        if ($request->hasFile('team_logo')) {
            $file = $request->file('team_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('assets/images/team_logo');
            $file->move($destinationPath, $filename);
            // save relative path in DB
            $teamPath = $filename;
        }
        $team = Team::create([
            'post_title' => $request->post_title,
            'team_id' => $request->team_id,
            'divanscore_home_id' => $request->divanscore_home_id,
            'divanscore_away_id' => $request->divanscore_away_id,
            'divanscore_tournament_id' => $request->divanscore_tournament_id,
            'divanscore_season_id' => $request->divanscore_season_id,
            'team_logo' => $teamPath ?? null,
            'team_country' => $request->team_country,
            'team_city' => $request->team_city,
            'team_venue' => $request->team_venue,
            'team_manager' => $request->team_manager,
            'league_id' => $request->league_id,
            'season_id' => $request->season_id,
            'language_id' => $request->language_id,
            'default_language_post_id' => 0,
            'created_by' => auth()->id(),
        ]);

        // SAVE PLAYERS
        if ($request->has('players') && is_array($request->players)) {

            foreach ($request->players as $index => $player) {

                // skip empty rows
                if (!isset($player['name']) || empty(trim($player['name']))) {
                    continue;
                }

                $photoPath = null;

                // handle file upload
                if ($request->hasFile("players.$index.photo")) {
                    $file = $request->file("players.$index.photo");
                    $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('assets/images/player_photo');
                    $file->move($destinationPath, $filename);
                    $photoPath = $filename;
                }

                TeamPlayer::create([
                    'team_id'  => $team->id,
                    'name'     => $player['name'] ?? null,
                    'age'      => $player['age'] ?? null,
                    'number'   => $player['number'] ?? null,
                    'position' => $player['position'] ?? null,
                    'rating'   => $player['rating'] ?? null,
                    'photo'    => $photoPath,
                    'language_id' => $team->language_id,
                    'default_language_post_id' => $team->default_language_post_id,
                    'created_by' => auth()->id(),
                ]);

            }
        }

        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
    }

    public function edit($id, $language_id, $default_language_post_id)
    {
        $team = Team::findOrFail($id);
        $language = LanguageMaster::findOrFail($language_id);
        $pageTitle = 'Edit '. $team->post_title .' - '.$language->fullname.' language';
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        $team = Team::findOrFail($id);
        return view('admin.team.edit', compact('pageTitle', 'leagues', 'seasons', 'languages', 'team', 'language_id', 'default_language_post_id'));
    }

    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'league_id'=> 'required',
            'season_id'=> 'required',
            // 'language_id'=> 'required',
            'team_id'=> 'nullable|integer',
            'divanscore_home_id'=> 'nullable|integer',
            'divanscore_away_id'=> 'nullable|integer',
            'divanscore_tournament_id'=> 'nullable|integer',
            'divanscore_season_id'=> 'nullable|integer',
        ],
        [
            'post_title.required' => 'The team name field is required.',
        ] 
        );

        $team = Team::findOrFail($id);
        $teamPath = $team->team_logo; // existing logo path

        if ($request->hasFile('team_logo')) {
            if($team->team_logo && file_exists(public_path('assets/images/team_logo/' . $team->team_logo))) {
                unlink(public_path('assets/images/team_logo/' . $team->team_logo)); // delete existing logo
            }
            $file = $request->file('team_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('assets/images/team_logo');
            $file->move($destinationPath, $filename);
            // save relative path in DB
            $teamPath = $filename;
        }

        $team->update([
            'post_title' => $request->post_title,
            'team_id' => $request->team_id,
            'divanscore_home_id' => $request->divanscore_home_id,
            'divanscore_away_id' => $request->divanscore_away_id,
            'divanscore_tournament_id' => $request->divanscore_tournament_id,
            'divanscore_season_id' => $request->divanscore_season_id,
            'team_logo' => $teamPath ?? null,
            'team_country' => $request->team_country,
            'team_city' => $request->team_city,
            'team_venue' => $request->team_venue,
            'team_manager' => $request->team_manager,
            'league_id' => $request->league_id,
            'season_id' => $request->season_id,
            'language_id' => $language_id,
            'updated_by' => auth()->id(),
        ]);

        // collect request player ids
        $requestIds = collect($request->players)->pluck('id')->filter()->toArray();


        // DELETE removed players + unlink image
        $playersToDelete = TeamPlayer::where('team_id', $team->id)
            ->whereNotIn('id', $requestIds)
            ->get();

        foreach ($playersToDelete as $player) {

            if ($player->photo) {

                $path = public_path('assets/images/player_photo/' . $player->photo);

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $player->delete();
        }



        // UPDATE or CREATE players
        if ($request->has('players')) {

            foreach ($request->players as $index => $player) {

                if (empty($player['name'])) {
                    continue;
                }

                $photoPath = $player['existing_photo'] ?? null;

                // upload new photo
                if ($request->hasFile("players.$index.photo")) {

                    // delete old photo if exists
                    if (!empty($player['existing_photo'])) {

                        $oldPath = public_path('assets/images/player_photo/' . $player['existing_photo']);

                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }

                    $file = $request->file("players.$index.photo");
                    $filename = time().'_'.$index.'_'.$file->getClientOriginalName();
                    $destinationPath = public_path('assets/images/player_photo');
                    $file->move($destinationPath, $filename);
                    $photoPath = $filename;
                }


                TeamPlayer::updateOrCreate(

                    [
                        'id' => $player['id'] ?? null
                    ],

                    [
                        'team_id'  => $team->id,
                        'name'     => $player['name'],
                        'age'      => $player['age'],
                        'number'   => $player['number'],
                        'position' => $player['position'],
                        'rating'   => $player['rating'],
                        'photo'    => $photoPath,
                        'language_id' => $language_id,
                        'default_language_post_id' => $default_language_post_id,
                        'created_by' => auth()->id(),
                    ]
                );

            }
        }


        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully.');
    }

    public function addSubTeam($id, $language_id)
    {
        $team = Team::findOrFail($id);
        $language = LanguageMaster::findOrFail($language_id);

        $pageTitle = 'Add Team - '.$team->post_title.' in  ('.$language->fullname.') language';
        $leagues = League::where('status', 1)->get();
        $seasons = Season::where('status', 1)->get();
        $languages = LanguageMaster::where('status', 1)->get();
        return view('admin.team.add_sub', compact('pageTitle', 'team', 'language', 'leagues', 'seasons', 'languages', 'id', 'language_id'));
    }

    public function storeSubTeam(Request $request, $id, $language_id)
    {
        $request->validate([
            'post_title' => 'required|string|max:255',
            'league_id'=> 'required',
            'season_id'=> 'required',
            'team_id'=> 'nullable|integer',
            'divanscore_home_id'=> 'nullable|integer',
            'divanscore_away_id'=> 'nullable|integer',
            'divanscore_tournament_id'=> 'nullable|integer',
            'divanscore_season_id'=> 'nullable|integer',
        ],
        [
            'post_title.required' => 'The team name field is required.',
        ] 
        );

        $teamPath = $request->existing_team_logo; // existing logo path
        if ($request->hasFile('team_logo')) {
            $file = $request->file('team_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('assets/images/team_logo');
            $file->move($destinationPath, $filename);
            // save relative path in DB
            $teamPath = $filename;
        }

        $team = Team::create([
            'post_title' => $request->post_title,
            'team_id' => $request->team_id,
            'divanscore_home_id' => $request->divanscore_home_id,
            'divanscore_away_id' => $request->divanscore_away_id,
            'divanscore_tournament_id' => $request->divanscore_tournament_id,
            'divanscore_season_id' => $request->divanscore_season_id,
            'team_logo' => $teamPath ?? null,
            'team_country' => $request->team_country,
            'team_city' => $request->team_city,
            'team_venue' => $request->team_venue,
            'team_manager' => $request->team_manager,
            'league_id' => $request->league_id,
            'season_id' => $request->season_id,
            'language_id' => $language_id,
            'default_language_post_id' => $id,
            'created_by' => auth()->id(),
        ]);

        // SAVE PLAYERS
        if ($request->has('players') && is_array($request->players)) {

            foreach ($request->players as $index => $player) {

                // skip empty rows
                if (!isset($player['name']) || empty(trim($player['name']))) {
                    continue;
                }

                $photoPath = $request->input("players.$index.existing_photo"); // existing photo path

                // handle file upload
                if ($request->hasFile("players.$index.photo")) {
                    $file = $request->file("players.$index.photo");
                    $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $destinationPath = public_path('assets/images/player_photo');
                    $file->move($destinationPath, $filename);
                    $photoPath = $filename;
                }

                TeamPlayer::create([
                    'team_id'  => $team->id,
                    'name'     => $player['name'] ?? null,
                    'age'      => $player['age'] ?? null,
                    'number'   => $player['number'] ?? null,
                    'position' => $player['position'] ?? null,
                    'rating'   => $player['rating'] ?? null,
                    'photo'    => $photoPath,
                    'language_id' => $team->language_id,
                    'default_language_post_id' => $team->default_language_post_id,
                    'created_by' => auth()->id(),
                ]);

            }
        }

        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
    }

    public function delete(Request $request)
    {
        $team_delete = Team::findOrFail($request->deleteid);
        if($team_delete->team_logo && file_exists(public_path('assets/images/team_logo/' . $team_delete->team_logo))) {
            unlink(public_path('assets/images/team_logo/' . $team_delete->team_logo));
        }
        $team_delete->delete();
        $translationsToDelete = Team::where('default_language_post_id', $request->deleteid)->get();
        foreach ($translationsToDelete as $translation) {
            $translation->delete();
        }
        $playersToDelete = TeamPlayer::where('team_id', $request->deleteid)->orWhere('default_language_post_id', $request->deleteid)->get();
        foreach ($playersToDelete as $player) {
            if ($player->photo) {
                $path = public_path('assets/images/player_photo/' . $player->photo);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $player->delete();
        }

        if ($team_delete) {
            return response()->json(['status' => true, 'message' => 'Team deleted successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete season.']);
        }
    }
}

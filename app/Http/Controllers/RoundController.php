<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;
use App\Models\LanguageMaster;

class RoundController extends Controller
{
    //

    public function index()
    {
        $pageTitle = 'Rounds';
        $languages = LanguageMaster::all();
        return view('admin.round.index', compact('pageTitle', 'languages'));
    }

    public function data()
    {
        $rounds = Round::where('default_language_post_id', 0)->get();
        $languages = LanguageMaster::all();

        return datatables()->of($rounds)
        ->addColumn('languages', function ($round) use ($languages) {
            $buttons = '';
            foreach ($languages as $language) {

                $translation = Round::where('language_id', $language->id)
                    ->where(function ($query) use ($round) {
                        $query->where('id', $round->id)
                            ->orWhere('default_language_post_id', $round->id);
                    })
                    ->first();

                if ($translation) {

                    // EDIT button
                    $url = route('admin.rounds.edit', [
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
                    $url = route('admin.sub-round.add', [
                        'id' => $round->id,
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
        $pageTitle = 'Create Round';
        $languages = LanguageMaster::where('status', 1)->get();
        return view('admin.round.create', compact('pageTitle', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tag_name' => 'required|string|max:255',
            'slug'=> 'required|string|max:255|unique:rounds,slug',
            'custom_uri' => 'required|string|max:255',
            'language_id'=> 'required',
        ],
        [
            'tag_name.required' => 'The Round name field is required.', 
        ]);

        Round::create([
            'tag_name' => $request->tag_name,
            'slug' => $request->slug,
            'round_type' => $request->round_type,
            'custom_uri' => $request->custom_uri,
            'language_id' => $request->language_id,
        ]);

        return redirect()->route('admin.rounds.index')->with('success', 'Round created successfully.');
    }

    public function edit($id, $language_id, $default_language_post_id)
    {
        $round = Round::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Edit '. $round->tag_name . ' - '.$language->fullname.' language';
        return view('admin.round.edit', compact('pageTitle', 'round', 'language_id', 'default_language_post_id'));
    }

    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        $request->validate([
            'tag_name' => 'required|string|max:255',
            'slug'=> 'required|string|max:255|unique:rounds,slug,' . $id,
            'custom_uri' => 'required|string|max:255',
        ],
        [
            'tag_name.required' => 'The Round name field is required.', 
        ]);

        $round = Round::findOrFail($id);

        $round->update([
            'tag_name' => $request->tag_name,
            'slug' => $request->slug,
            'round_type' => $request->round_type,
            'custom_uri' => $request->custom_uri,
            'language_id' => $language_id,
            'default_language_post_id' => $default_language_post_id,
        ]);

        return redirect()->route('admin.rounds.index')->with('success', 'Round updated successfully.');
    }

    public function addSubRound($id, $language_id)
    {
        $round = Round::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Add Round - '. $round->tag_name . ' in ('.$language->fullname.') language';
        return view('admin.round.add_sub', compact('pageTitle', 'round', 'id', 'language_id'));
    }

    public function storeSubRound(Request $request, $id, $language_id)
    {
        $request->validate([
            'tag_name' => 'required|string|max:255',
            'slug'=> 'required|string|max:255|unique:rounds,slug',
            'custom_uri' => 'required|string|max:255',
        ],
        [
            'tag_name.required' => 'The Round name field is required.', 
        ]);

        Round::create([
            'tag_name' => $request->tag_name,
            'slug' => $request->slug,
            'round_type' => $request->round_type,
            'custom_uri' => $request->custom_uri,
            'language_id' => $language_id,
            'default_language_post_id' => $id,
        ]);

        return redirect()->route('admin.rounds.index')->with('success', 'Round created successfully.');  
    }

    public function delete(Request $request)
    {
        Round::where('id', $request->deleteid)->delete();
        $sub_rounds = Round::where('default_language_post_id', $request->deleteid)->get();
        foreach($sub_rounds as $round)
        {
            $round->delete();
        }

        return response()->json(['status' => true, 'message' => 'Team deleted successfully.']);
    }
}

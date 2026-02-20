<?php

namespace App\Http\Controllers;

use App\Models\LanguageMaster;
use App\Models\StatType;
use Illuminate\Http\Request;

class StatTypeController extends Controller
{
    
    public function index()
    {
        $pageTitle = 'Stat Type';
        $languages = LanguageMaster::all();
        return view('admin.stat_type.index', compact('pageTitle', 'languages'));
    }

    public function data()
    {
        $Stat_types = StatType::where('default_language_post_id', 0)->get();
        $languages = LanguageMaster::all();
        
        return datatables()->of($Stat_types)
        ->editColumn('status', function ($Stat_type) {
            return $Stat_type->status
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
        })
        ->addColumn('languages', function ($Stat_type) use ($languages) {

            $buttons = '';
            foreach ($languages as $language) {

                $translation = StatType::where('language_id', $language->id)
                    ->where(function ($query) use ($Stat_type) {
                        $query->where('id', $Stat_type->id)
                            ->orWhere('default_language_post_id', $Stat_type->id);
                    })
                    ->first();

                if ($translation) {

                    // EDIT button
                    $url = route('admin.stat-type.edit', [
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
                    $url = route('admin.sub-stat-type.add', [
                        'id' => $Stat_type->id,
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
        ->addColumn('action', function ($Stat_type) {
            $buttons = '
                <br>
                <a href="javascript:void(0)" 
                data-deleteid="'.$Stat_type->id.'"
                class="btn btn-sm btn-danger show-remove-modal">
                Delete All
                </a>
            ';
            return $buttons;
        })

        ->rawColumns(['languages', 'action', 'status'])
        ->make(true);
    }

    public function create()
    {
        $pageTitle = 'Create Stat Type';
        $languages = LanguageMaster::where('status', 1)->get();
        return view('admin.stat_type.create', compact('pageTitle', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stat_name' => 'required',
            'language_id' => 'required'
        ]);

        StatType::create([
            'stat_name' => $request->stat_name,
            'status' => $request->status,
            'language_id' => $request->language_id
        ]);

        return redirect()->route('admin.stat-type.index')->with('success', 'Stat Type Created Successfully');
    }

    public function edit($id, $language_id, $default_language_post_id)
    {
        $stat_type = StatType::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Edit '. $stat_type->stat_name .' - '.$language->fullname.' language';
        return view('admin.stat_type.edit', compact('pageTitle', 'stat_type', 'language_id', 'default_language_post_id'));
    }

    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        $request->validate([
            'stat_name' => 'required',
        ]);
        $stat_type = StatType::findorfail($id);
        $stat_type->update(
        [
            'stat_name' => $request->stat_name,
            'status' => $request->status,
            'language_id' => $language_id,
            'default_language_post_id' => $default_language_post_id
        ]);

        return redirect()->route('admin.stat-type.index')->with('success', 'Stat Type Updated Successfully');
    }

    public function addSubStatType($id, $language_id)
    {
        $stat_type = StatType::where('id', $id)->first();
        $language = LanguageMaster::where('id', $language_id)->first();
        $pageTitle = 'Add Stat Type '. $stat_type->post_title .' in  ('.$language->fullname.') language';
        return view('admin.stat_type.add_sub', compact('pageTitle', 'language_id', 'stat_type'));
    }

    public function storeSubStatType(Request $request, $id, $language_id)
    {
        $request->validate([
            'stat_name' => 'required',
        ]);

         StatType::create([
            'stat_name' => $request->stat_name,
            'status' => $request->status,
            'language_id' => $language_id,
            'default_language_post_id' => $id
        ]);

        return redirect()->route('admin.stat-type.index')->with('success', 'Stat Type Created Successfully');
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->deleteid;
            if($id)
            {
                StatType::where('id', $id)->orWhere('default_language_post_id', $id)->delete();
                return response()->json(['status' => true, 'message' => 'Stat Type deleted successfully']);
            }
        }
        catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to delete Stat Type']);
        }
    }
}

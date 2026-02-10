<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\LanguageMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    public function index()
    {
        $pageTitle = 'Countries';
        $languages = LanguageMaster::all();
        return view('admin.country.index', compact('pageTitle', 'languages'));
    }
    public function create()
    {
        $pageTitle = 'Add Country';
        $languages = LanguageMaster::where('status', 1)->get();
        return view('admin.country.create', compact('pageTitle', 'languages'));
    }
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:countries,slug',
                'country_code' => 'required|string|max:10',
                'language_id' => 'required|exists:language_masters,id',
                'status' => 'required|in:0,1',
                'country_flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $countryFlagPath = null;

            if ($request->hasFile('country_flag')) {
                $file = $request->file('country_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/country_flags');
                $file->move($destinationPath, $filename);
                // save relative path in DB
                $countryFlagPath = $filename;
            }
            $userId = 1;
            if (Auth::check()) {
                $userId = Auth::id();
            }
            $country = new Country();
            $country->name = $request->name;
            $country->country_code = $request->country_code;
            $country->slug = $request->slug;
            $country->custom_permalink = $request->custom_permalink;
            $country->language_id = $request->language_id;
            $country->status = $request->status;
            $country->country_flag = $countryFlagPath;
            $country->created_by = $userId;
            $country->save();
            return redirect()->route('admin.countries.index')->with('success', 'Country added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while adding the country: ' . $e->getMessage())->withInput();
        }
    }
    public function edit($id, $language_id, $default_language_post_id)
    {
        $pageTitle = 'Edit Country';
        $country = Country::findOrFail($id);
        $languages = LanguageMaster::where('status', 1)->get();
        return view('admin.country.edit', compact('pageTitle', 'country', 'languages', 'language_id' , 'default_language_post_id'));
    }
    public function update(Request $request, $id, $language_id, $default_language_post_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'country_code' => 'required|string|max:10',
                'status' => 'required|in:0,1',
                'country_flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $countryFlagPath = $request->existing_path;
            if ($request->hasFile('country_flag')) {
                $file = $request->file('country_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/country_flags');
                $file->move($destinationPath, $filename);
                // Update country flag path
                $country = Country::findOrFail($id);
                $countryFlagPath = $filename;
            }
            $userId = 1;
            if (Auth::check()) {
                $userId = Auth::id();
            }
            $country = Country::findOrFail($id);
            $country->name = $request->name;
            $country->country_code = $request->country_code;
            $country->slug = $request->slug;
            $country->custom_permalink = $request->custom_permalink;
            $country->language_id = $language_id;
            $country->default_language_post_id = $default_language_post_id;
            $country->country_flag = $countryFlagPath ?? null;
            $country->status = $request->status;
            $country->updated_by = $userId;
            $country->save();
            return redirect()->route('admin.countries.index')->with('success', 'Country updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the country: ' . $e->getMessage())->withInput();
        }
    }
    public function data(Request $request)
    {
        $query = Country::select('id', 'name', 'country_code', 'status')->where('status', 1)->where('default_language_post_id', 0);
        $languages = LanguageMaster::all();

        if ($request->filled('filter_language') && $request->filter_language != -1) {
            $filterLanguage = (int) $request->filter_language;
            $query->where('language_id', $filterLanguage);
        }
        return DataTables::of($query)
            ->addColumn('country_code', fn($row) => '+' . $row->country_code)
            ->editColumn('status', function ($row) {
                return $row->status
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('languages', function ($row) use ($languages) {

                $buttons = '';
                foreach ($languages as $language) {

                    $translation = Country::where('language_id', $language->id)
                        ->where(function ($query) use ($row) {
                            $query->where('id', $row->id)
                                ->orWhere('default_language_post_id', $row->id);
                        })
                        ->first();

                    if ($translation) {

                        // EDIT button
                        $url = route('admin.countries.edit', [
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
                        $url = route('admin.sub-country.add', [
                            'id' => $row->id,
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
            ->addColumn('action', function ($row) {
                return '
                    <a href="javascript:void(0)" 
                       data-deleteid="' . $row->id . '" 
                       class="btn btn-sm btn-danger show-remove-modal">
                       Delete all
                    </a>
                ';
            })
            ->rawColumns(['status', 'action', 'languages'])
            ->make(true);
    }

    public function addSubCountry($id, $language_id)
    {
        $country = Country::findOrFail($id);
        $language = LanguageMaster::findOrFail($language_id);
        $pageTitle = 'Add Country - '.$country->name.' in  ('.$language->fullname.') language';
        return view('admin.country.add_sub', compact('pageTitle', 'country', 'id', 'language_id'));
    }

    public function storeSubCountry(Request $request, $id, $language_id)
    {
        $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:countries,slug',
                'country_code' => 'required|string|max:10',
                'status' => 'required|in:0,1',
                'country_flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $countryFlagPath = $request->existing_path;

            if ($request->hasFile('country_flag')) {
                $file = $request->file('country_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/country_flags');
                $file->move($destinationPath, $filename);
                // save relative path in DB
                $countryFlagPath = $filename;
            }
            $userId = 1;
            if (Auth::check()) {
                $userId = Auth::id();
            }
            $country = new Country();
            $country->name = $request->name;
            $country->country_code = $request->country_code;
            $country->slug = $request->slug;
            $country->custom_permalink = $request->custom_permalink;
            $country->language_id = $language_id;
            $country->default_language_post_id = $id;
            $country->status = $request->status;
            $country->country_flag = $countryFlagPath ?? null;
            $country->created_by = $userId;
            $country->save();
            return redirect()->route('admin.countries.index')->with('success', 'Country added successfully.');
    }

    public function delete(Request $request)
    {
        $isdelete = Country::where('id', $request->deleteid)->first();
        if ($isdelete) {
            unlink(public_path('assets/images/country_flags/' . $isdelete->country_flag));
            $isdelete->delete();
            $sub_countries = Country::where('default_language_post_id', $request->deleteid)->get();
            foreach($sub_countries as $country){
                if ($country->country_flag) {
                    $path = public_path('assets/images/country_flags/' . $country->country_flag);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $country->delete();
            }
            return response()->json(['status' => true, 'message' => 'Country deleted']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete country']);
        }
        
    }
}

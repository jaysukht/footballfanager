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
                'slug' => 'required|string|max:255',
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
    public function edit($id)
    {
        $pageTitle = 'Edit Country';
        $country = Country::findOrFail($id);
        $languages = LanguageMaster::where('status', 1)->get();
        return view('admin.country.edit', compact('pageTitle', 'country', 'languages'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
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
            if ($request->hasFile('country_flag')) {
                $file = $request->file('country_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/country_flags');
                $file->move($destinationPath, $filename);
                // Update country flag path
                $country = Country::findOrFail($id);
                $country->country_flag = $filename;
                $country->save();
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
            $country->language_id = $request->language_id;
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
        $query = Country::select('id', 'name', 'country_code', 'status')->where('status', 1);
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
            ->addColumn('action', function ($row) {
                return '
                    <a href="javascript:void(0)" 
                       data-deleteid="' . $row->id . '" 
                       class="btn btn-sm btn-danger show-remove-modal">
                       Delete
                    </a>
                    <a href="' . route('admin.countries.edit', $row->id) . '" 
                       class="btn btn-sm btn-primary">
                       Edit
                    </a>
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function delete(Request $request)
    {
        try {
            $isdelete = Country::where('id', $request->deleteid)->delete();
            if ($isdelete) {
                return response()->json(['status' => true, 'message' => 'Country deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to delete country']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the country.',
            ], 500);
        }
    }
}

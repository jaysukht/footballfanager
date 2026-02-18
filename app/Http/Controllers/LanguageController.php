<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LanguageMaster;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    //
    public function index()
    {
        $pageTitle = 'Languages';
        return view('admin.language.index', compact('pageTitle'));
    }
    public function create()
    {
        $pageTitle = 'Add Language';
        return view('admin.language.create', compact('pageTitle'));
    }
    public function edit($id)
    {
        $pageTitle = 'Edit Language';
        $language = LanguageMaster::findOrFail($id);
        return view('admin.language.edit', compact('pageTitle', 'language'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'shortname' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'fullname' => 'required|string|max:255',
                'status' => 'required|in:0,1',
                'lang_flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $userId = 1;
            if (Auth::check()) {
                $userId = Auth::id();
            }
            if ($request->hasFile('lang_flag')) {
                $file = $request->file('lang_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/language_flags');
                $file->move($destinationPath, $filename);
                // Update language flag path
                $language = LanguageMaster::findOrFail($id);
                $language->lang_flag = $filename;
                $language->save();
            }
            $language = LanguageMaster::findOrFail($id);
            $language->slug = $request->slug;
            $language->shortname = $request->shortname;
            $language->fullname = $request->fullname;
            $language->status = $request->status;
            $language->updated_by = $userId;
            $language->save();
            return redirect()->route('admin.languages.index')->with('success', 'Language updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the language: ' . $e->getMessage())->withInput();
        }
    }   
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'shortname' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'fullname' => 'required|string|max:255',
                'status' => 'required|in:0,1',
                'lang_flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $userId = 1;
            if (Auth::check()) {
                $userId = Auth::id();
            }
          
            $langFlagPath = null;
            if ($request->hasFile('lang_flag')) {
                $file = $request->file('lang_flag');
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('assets/images/language_flags');
                $file->move($destinationPath, $filename);
                // save relative path in DB
                $langFlagPath = $filename;
            }
            $language = new LanguageMaster();
            $lang_slug = strtolower(str_replace(' ', '_', $request->fullname));
            $language->slug = $request->slug ?? $lang_slug;
            $language->shortname = $request->shortname ?? substr($lang_slug, 0, 2);
            $language->fullname = $request->fullname;
            $language->lang_flag = $langFlagPath ?? null;
            $language->status = $request->status;
            $language->created_by = $userId;
            $language->updated_by = $userId;
            $language->save();
            return redirect()->route('admin.languages.index')->with('success', 'Language added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while adding the language: ' . $e->getMessage())->withInput();
        }
    }
    public function data(Request $request)
    {
        $query = LanguageMaster::select('id', 'fullname', 'status')->where('status', 1);
        return DataTables::of($query)
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
                    <a href="' . route('admin.languages.edit', $row->id) . '" 
                       class="btn btn-sm btn-primary orange-bg">
                       Edit
                ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    public function delete(Request $request)
    {
        try {
            $isdelete = LanguageMaster::where('id', $request->deleteid)->delete();
            if ($isdelete) {
                return response()->json(['status' => true, 'message' => 'Language deleted']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to delete language']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the language.',
            ], 500);
        }
    }
}

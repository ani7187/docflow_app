<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\permission\Permission;
use App\Models\section\Section;
use App\Models\sectionAdditionalColumn\SectionAdditionalColumn;
use App\Models\User;
use App\Models\userGroup\UserGroup;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $user = Auth::user();
//        $id = $user->partnerOrganization->id;
//
//        $partnerOrganization = PartnerOrganization::findOrFail($id);
//        $partnerPersons = $partnerOrganization->partnerPersons;
//
//        $users = [];
//        foreach ($partnerPersons as $key => $partnerPerson) {
//            $users[] = User::findOrFail($partnerPerson->user_id);
////            $partnerPersons[$key]["user"]["email"] = $user["email"];
//        }
//
//        $userGroups = UserGroup::where('owner_id', auth()->user()->id)->get();

        $sections = Section::where('user_id', auth()->user()->id)->get();
        return view('sections.index', compact('sections')); //, 'users', 'userGroups'
    }

    public function create()
    {
        return view('sections.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'additional_column.*' => 'nullable|string', // Adjust validation rules for additional columns
        ]);

        try {
            // Retrieve user ID and request data
            $userId = auth()->user()->id;
//            dd($userId);
            $additionalColumns = $validatedData['additional_column'] ?? [];

            DB::beginTransaction();

            // Create a new section
            $section = new Section();
            $section->name = $request->name;
            $section->description = $request->description;
            $section->user_id = auth()->user()->id;
            $section->save();

            // Create additional columns for the section
            $additionalColumnData = array_fill_keys($additionalColumns, true);
            $section->additionalColumns()->create($additionalColumnData);

            // Create default permissions for the section
            $section->permissions()->create([
                'user_id' => $userId,
                'can_preview' => true,
                'can_view' => true,
                'can_edit' => true,
                'can_add' => true,
            ]);

            DB::commit();

            return redirect()->route('sections.index')->with('success', Lang::get('menu.success_create'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function edit(Section $section)
    {
        $properties = [
            'number', 'name', 'notes', 'uploaded_by', 'signed_by', 'creation_date', 'due_date'
        ];

        $additionalColumns = [];
        // Iterate over the properties and add the corresponding value to $additionalColumns
        if (!empty($section->additionalColumns)) {
            foreach ($properties as $property) {
                if ($section->additionalColumns->$property) {
                    $additionalColumns[] = $property;
                }
            }
        }

        return view('sections.edit', compact('section', 'additionalColumns'));
    }

    public function update(Request $request, Section $section)
    {
//        dd($request);
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sections')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user()->id);
                })->ignore($section->id),
            ],
            'description' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            $section->update($request->all());

            $sectionAdditionalColumn = SectionAdditionalColumn::where('section_id', $section->id)->first();
            if (!$sectionAdditionalColumn) {
                $sectionAdditionalColumn = new SectionAdditionalColumn(['section_id' => $section->id]);
            }

            // Update the properties of the section additional column
            $additionalColumns = $request->input('additional_column', []);
            $attributes = array_fill_keys(['number', 'name', 'notes', 'uploaded_by', 'signed_by', 'creation_date', 'due_date'], false);
            foreach ($additionalColumns as $column) {
                $attributes[$column] = true;
            }
            $sectionAdditionalColumn->update($attributes);


            DB::commit();
            return redirect()->route('sections.edit', $section->id)->with('success', Lang::get('menu.success_edit'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());//Lang::get('menu.error_create')
        }
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', Lang::get('menu.success_delete'));
    }
}

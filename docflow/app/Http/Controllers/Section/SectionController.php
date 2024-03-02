<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\section\Section;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{

    protected $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->middleware('auth');
        $this->sectionService = $sectionService;
    }

    public function index()
    {
        $sections = Section::all();
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        return view('sections.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

//        dd(auth()->user()->id);

        // Create a new section instance and fill it with the request data
        $section = new Section();
        $section->name = $request->name;
        $section->description = $request->description;
        $section->user_id = auth()->user()->id;
        $section->save();

        // Redirect the user back to the index page with a success message
        return redirect()->route('sections.index')->with('success', Lang::get('menu.success_create'));
    }

    public function edit(Section $section)
    {
        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
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

        $section->update($request->all());

        return redirect()->route('sections.index')->with('success', Lang::get('menu.success_edit'));
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')->with('success', Lang::get('menu.success_delete'));
    }
}

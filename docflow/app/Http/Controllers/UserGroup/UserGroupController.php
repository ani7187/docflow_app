<?php

namespace App\Http\Controllers\UserGroup;

use App\Http\Controllers\Controller;
use App\Models\userGroup\UserGroup;
use App\Models\userGroup\UserGroupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserGroupController extends Controller
{
    public function show()
    {
        $userGroups = UserGroup::where('owner_id', auth()->user()->id)->get();

        return view('admin.user_groups.index', compact('userGroups'));
    }

    public function add()
    {
        return view('admin.user_groups.add');
    }

    public function store(Request $request)
    {
//        dd($request->hasFile('file'));
        $ownerId = auth()->user()->id;
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255|' . Rule::unique('user_groups')->where('owner_id', $ownerId),
            ],
            [
                'name.required' => 'Այս դաշտը պարտադիր է.',
                'name.unique' => 'Արդեն գոյություն ունի'
            ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            // Create new group
            UserGroup::create([
                'name' => $request->input('name'),
                'owner_id' => auth()->user()->id,
            ]);
            DB::commit();
            return redirect()->route('user_groups')->with('success', 'Հաջողությամբ ստեղծվեց:');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(UserGroup $group)
    {
        return view('admin.user_groups.edit', compact('group'));
    }

    public function update(Request $request, UserGroup $group)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255|' . Rule::unique('user_groups')->where(function ($query) use ($user) {
                        return $query->where('owner_id', $user->id);
                    })->ignore($group->id),
            ],
            [
                'name.required' => 'Այս դաշտը պարտադիր է.',
                'name.unique' => 'Արդեն գոյություն ունի'
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $group->update(["name" => $request->input("name")]);
            DB::commit();

            return redirect()->route('user_groups')->with('success', 'Հաջողությամբ խմբագրվեց:');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(UserGroup $group)
    {
        $group->delete();

        return redirect()->route('user_groups')->with('success', 'Հաջողությամբ հեռացվեց:');
    }
}

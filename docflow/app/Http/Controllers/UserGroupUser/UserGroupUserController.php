<?php

namespace App\Http\Controllers\UserGroupUser;

use App\Http\Controllers\Controller;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\User;
use App\Models\userGroup\UserGroup;
use App\Models\userGroupUser\UserGroupUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserGroupUserController extends Controller
{
    public function show(UserGroup $group)
    {

        $userGroup = UserGroup::findOrFail($group->id);
        $userGroupUsers = $userGroup->users()->get();

        $groupID = $group->id;
        return view('admin.user_group_user.index', compact('userGroupUsers', 'groupID'));
    }

    public function detach($userGroupId, $userId)
    {
        $userGroup = UserGroup::find($userGroupId);
        if (!$userGroup) {
            return redirect()->back()->withInput()->with('error', 'Խնդիր, խումբը չի գտնվել:');
        }

        $userGroup->users()->detach($userId);

        return redirect()->route('user_group_user', ["group" => $userGroupId])->with('success', 'Հաջողությամբ հեռացվեց:');
    }


    public function add($group)
    {
        $user = Auth::user();
        $id = $user->partnerOrganization->id;
        $groupName = UserGroup::find($group)->name;

        $partnerOrganization = PartnerOrganization::findOrFail($id);
        $partnerPersons = $partnerOrganization->partnerPersons;

        $users = [];
        foreach ($partnerPersons as $key => $partnerPerson) {
            $users[] = User::findOrFail($partnerPerson->user_id);
        }
        return view('admin.user_group_user.add', compact('group', 'groupName', 'users'));
    }

    public function store(Request $request, $group) //group is groupId
    {
//        dd($request->user_ids);
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => [
                'exists:users,id',
                Rule::unique('user_group_user', 'user_id')->where(function ($query) use ($group) {
                    return $query->where('user_group_id', $group);
                }),
            ],
        ],[
            'user_ids.required' => 'Այս դաշտը պարտադիր է:',
            'user_ids.*.unique' => 'Յուրաքանչյուր օգտվող կարող է միայն մեկ անգամ ավելացվել խմբին:',
        ]);
//        dd("start0");

        if ($validator->fails()) {
            $errors = $validator->errors();
//dd($request->user_ids, $errors);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Retrieve the user group instance
            $userGroup = UserGroup::findOrFail($group);
            if (!$userGroup) {
                return redirect()->back()->withInput()->with('error', 'Խնդիր, խումբը չի գտնվել:');
            }
            // Attach users to the user group
            $userGroup->users()->attach($request->user_ids);

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('user_group_user', compact('group'))->with('success', 'Հաջողությամբ ավելացվեց:');

        } catch (\Exception $e) {
            // Rollback the transaction in case of any exception
            DB::rollback();

            // Redirect back with error message
            return redirect()->back()->withInput()->with('error', 'Չհաջողվեց օգտվողներ ավելացնել օգտատերերի խմբին');
        }
    }
}

<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\permission\Permission;
use App\Models\section\Section;
use App\Models\User;
use App\Models\userGroup\UserGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display the permission control page for the specified section.
     *
     * @param Section $section
     * @return View
     */
    public function show(Section $section)
    {
        $user = Auth::user();

        $partnerOrganizationId = $user->partnerOrganization->id;
        $partnerOrganization = PartnerOrganization::with('partnerPersons')->findOrFail($partnerOrganizationId);
        $userIds = $partnerOrganization->partnerPersons->pluck('user_id')->toArray();
        $users = User::whereIn('id', $userIds)->get();
        $userGroups = UserGroup::where('owner_id', $user->id)->get();
//        dd($userGroups);

        $permissions = Permission::where('section_id', $section->id)
            ->with(['user', 'userGroup'])
            ->get();

        return view('sections.permissions.show', compact('section', 'users', 'userGroups', 'permissions'));
    }


    /**
     * Update permissions for the specified section.
     *
     * @param Request $request
     * @param Section $section
     * @return RedirectResponse
     */
    public function store(Request $request, Section $section)
    {
//        dd($request, $section);
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required_without_all:user_group_id|array',
            'user_id.*' => 'exists:users,id,deleted_at,NULL',
            'user_group_id' => 'required_without_all:user_id|array',
            'user_group_id.*' => 'exists:user_groups,id,deleted_at,NULL',
            'permission_type' => 'required|array',
            'permission_type.*' => 'in:can_preview,can_view,can_edit,can_add',
            'expires_at' => 'nullable|date|after_or_equal:today'
        ], [
            'user_id.required_without_all' => 'Օգտվողը կամ օգտատերերի խումբը պարտադիր է',
            'user_id.*.exists' => 'Ընտրված օգտվողն անվավեր է կամ ջնջված է',
            'user_group_id.required_without_all' => 'Օգտվողը կամ օգտատերերի խումբը պարտադիր է',
            'user_group_id.*.exists' => 'Ընտրված օգտվողների խումբն անվավեր է կամ ջնջված է',
            'permission_type.required' => 'Իրավասության տեսակը պարտադիր է',
            'permission_type.*.in' => 'Ընտրված իրավասության տեսակն անվավեր է',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            if (!empty($request->input("user_id"))) {
                $this->savePermission("user_id", $section->id, $request);
            }
            if (!empty($request->input("user_group_id"))) {
                $this->savePermission("user_group_id", $section->id, $request);
            }

            DB::commit();

            return redirect()->route('sections.permissions', $section)->with('success', Lang::get('menu.success_create'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());//Lang::get('menu.error_create')
        }
    }

    public function destroy(Permission $permission)
    {
        // Delete the permission
        $permission->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', Lang::get('menu.success_delete'));
    }
    /**
     * @param $type
     * @param $sectionID
     * @param $request
     * @return void
     */
    private function savePermission($type, $sectionID, $request): void
    {
        foreach ($request->input($type) as $index => $data) {

            $existingPermission = Permission::where($type, $data)
                ->where('section_id', $sectionID)
                ->first();

            if ($existingPermission) {
                $permission = $existingPermission;
            } else {
                $permission = new Permission();
            }

            if ($type == "user_id") {
                $permission->user_id = $data;
            } else if ($type == "user_group_id") {
                $permission->user_group_id = $data;
            }

            foreach ($request->input('permission_type') as $permissionType) {
                switch ($permissionType) {
                    case Permission::PERMISSION_PREVIEW :
                        $permission->can_preview = true;
                        break;
                    case Permission::PERMISSION_VIEW :
                        $permission->can_view = true;
                        break;
                    case Permission::PERMISSION_EDIT :
                        $permission->can_edit = true;
                        break;
                    case Permission::PERMISSION_ADD :
                        $permission->can_add = true;
                        break;
                }
            }

            $permission->expires_at = $request->input('expires_at');
            $permission->section_id = $sectionID;

            // Save the permission
            $permission->save();
        }
    }
}

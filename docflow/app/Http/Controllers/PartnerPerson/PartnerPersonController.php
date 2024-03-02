<?php

namespace App\Http\Controllers\PartnerPerson;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\partnerPerson\PartnerPerson;
use App\Models\User;
use App\Notifications\CustomVerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PartnerPersonController extends Controller
{

    public function add()
    {
        return view('admin.employee.add');
    }
    public function edit(User $user)
    {
//        $user = User::findOrFail($partnerPerson->user_id);

        $partnerPerson = $user->partnerPerson();

        return view('admin.employee.edit', compact('partnerPerson', 'user'));
    }

    public function store(Request $request)
    {
        $companyCode = $request->input("company_code");

        $rules = array(
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_code' => 'required|string|max:255|'.
                Rule::exists('partner_organizations')->where(function ($query) use ($companyCode) {
                    $query->whereNotNull('company_code')
                        ->where('company_code', $companyCode);
                }),
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $partnerOrganizationID = $user->partnerOrganization->id;

//            dd($user);

            $newUser = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => UserRole::EMPLOYEE,
            ]);

            PartnerPerson::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'patronymic_name' => $request->input('patronymic_name'),
                'position' => $request->input('position'),
                'company_code' => $request->input('company_code'),

                'user_id' => $newUser->id,
                'partner_organization_id' => $partnerOrganizationID,
            ]);
            DB::commit();
            $newUser->notify(new CustomVerifyEmailNotification());
            return redirect()->route('employee')->with('success', 'Հաջողությամբ ստեղծվեց:');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (empty($user)) {
            return redirect()->back()->withInput();
        }

        $rules["name"] = 'required|string|max:255|' . Rule::unique('users')->ignore($id);
        $rules["email"] = 'required|email|string|max:255|' . Rule::unique('users')->ignore($id);

        if (!empty($request->input("password"))) {
            $rules['password'] = 'string|min:8|confirmed';
        }
        $rules = array_merge($rules, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
//            'password' => 'string|min:8|confirmed',

//            'company_code' => ['required', 'string', 'max:255'],
        ]);

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if (!empty($request->input('password')) && $user["password"] != Hash::make($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();

            $user->partnerPerson()->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'patronymic_name' => $request->input('patronymic_name'),
                'position' => $request->input('position'),
            ]);
            DB::commit();
            return redirect()->route('employee.edit', $user->id)->with('success', 'Հաջողությամբ թարմացվեց:');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function softDelete(User $user)
    {
        try {
            DB::beginTransaction();

//            dd($user);
            $updateTree = [
                'delete_status' => true,
                'deleted_at' => now(),
            ];
//            dd($user->partnerPerson()->update(['delete_status' => true]));
            // Check if relationships exist before updating related records
            $user->update($updateTree);

            if ($user->partnerPerson()->exists()) {
                $user->partnerPerson()->update($updateTree);
            }

            // Update the del_status field

            DB::commit();
            return redirect()->route('employee')->with('success', 'Հաջողությամբ հեռացվեց:');
        } catch (\Exception $e) {
            DB::rollback();
            // Log the exception or provide more specific error messages
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\PartnerPerson;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\partnerPerson\PartnerPerson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PartnerPersonController extends Controller
{
    public function edit(User $user)
    {
//        $user = User::findOrFail($partnerPerson->user_id);

        $partnerPerson = $user->partnerPerson();

        return view('profile.employee.edit', compact('partnerPerson', 'user'));
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
}

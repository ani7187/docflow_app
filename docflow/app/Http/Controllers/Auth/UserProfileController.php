<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\partnerPerson\PartnerPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [];
        if ($user["name"] != $request->input("name")){
            $rules["name"] = 'required|string|max:255|unique:users';
        }
        if ($user["email"] != $request->input("email")){
            $rules["email"] = 'required|email|unique:users|string|max:255';
        }
        if (!empty($request->input("password"))) {
            $rules["password"] = 'string|min:8|confirmed';
        }

//        $rules = [
//            'name' => 'required|string|max:255|unique:users',
//            'email' => 'required|email|unique:users|string|max:255',
//            'password' => 'string|min:8|confirmed',
//        ];

        if ($user['role_id'] == \App\Models\UserRole::COMPANY) {
            $rules = array_merge($rules, [
                'organization_name' => 'required|string|max:255',
            ]);
        } elseif ($user['role_id'] == UserRole::EMPLOYEE) {
            $rules = array_merge($rules, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
//                'company_code' => ['required', 'string', 'max:255'],
            ]);
        }

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if (!empty($request->input('password')) && $user["password"] != Hash::make($request->input('password'))) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        if ($user["role_id"] == UserRole::COMPANY) {
            $user->partnerOrganization()->update([
                'organization_name' => $request->input('organization_name'),
                'organization_legal_type' => $request->input('organization_legal_type'),
                'registration_number' => $request->input('organization_legal_type'),
            ]);
        } elseif ($user["role_id"] == UserRole::EMPLOYEE) {
            $user->partnerPerson()->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'patronymic_name' => $request->input('patronymic_name'),
                'position' => $request->input('position'),
//                'company_code' => $request->input('company_code'),
            ]);
        }

        return redirect()->route('profile')->with('success', "Հաջողությամբ թարմացվեց:");
    }
}

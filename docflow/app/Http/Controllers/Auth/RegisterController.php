<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\partnerPerson\PartnerPerson;
use App\Models\UserRole;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        dd($data);

        $validator = Validator::make($data, ['role_id' => 'required|integer']);
        if ($validator->fails()) {
            return $validator;
        }

        $rules = [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ];
        if ($data['role_id'] == UserRole::COMPANY) {
            $rules = array_merge($rules, [
                'organization_name' => 'required|string|max:255',
            ]);
        } elseif ($data['role_id'] == UserRole::EMPLOYEE) {
            $rules = array_merge($rules, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'company_code' => 'required|string|max:255',
            ]);
        }

        $validator = Validator::make($data, $rules);

        if (array_key_exists('company_code', $data)) {
            $partnerOrg = PartnerOrganization::where('company_code', $data['company_code'])->first();
            if (!$partnerOrg) {
                // If partner organization does not exist, return with error
                $validator->errors()->add('company_code', 'Partner org with this code does not exist');
            }
        }

//        dd($validator->errors());
//        $activeTab = $data['role_id'] == UserRole::COMPANY ? 'company' : 'employee';

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role_id'],
            ]);

//            dd($data['role_id']);

            if ($data['role_id'] == UserRole::COMPANY) {
                // If the user's role is for partner organization
                // Generate a unique company code
                $companyCode = $this->generateCompanyCode();

                // Create the partner organization record
                $partnerOrg = PartnerOrganization::create([
                    'user_id' => $user->id,
                    'company_code' => $companyCode,
                    'organization_name' => "",//$data['organization_name'],
                    'organization_legal_type' => $data['organization_legal_type'],
                    'registration_number' => $data['registration_number'],
                ]);
            } else if ($data['role_id'] == UserRole::EMPLOYEE) {
//                dd($data['role_id']);

                // If the user's role is for partner people
                $partnerOrg = PartnerOrganization::where('company_code', $data['company_code'])->first();
//                dd($partnerOrg);

                // Create the partner person record linked to the partner organization
                $partnerPerson = PartnerPerson::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'patronymic_name' => $data['patronymic_name'],
                    'position' => $data['position'],
                    'company_code' => $partnerOrg->company_code,

                    'user_id' => $user->id,
                    'partner_organizations_id' => $partnerOrg->id,
                    // Assign other fields from the request data
                ]);
//                dd($user);

            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
        }
//        return $user;
    }

    private function generateCompanyCode()
    {
        do {
            $code = Str::random(6); // Adjust the length as needed
        } while (PartnerOrganization::where('company_code', $code)->exists());

        return $code;
    }

}

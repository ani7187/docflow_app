<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Mail\VerifyEmail;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\partnerPerson\PartnerPerson;
use App\Models\UserRole;
use App\Notifications\CustomVerifyEmailNotification;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/verification-required';
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
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
//        dd($data);
        $validator = Validator::make($data, ['role_id' => 'required|integer']);
        if ($validator->fails()) {
            return $validator;
        }

//        $messages = [//todo lang
//            'email.required' => 'Email is required.',
//            'email.email' => 'Please enter a valid email address.',
//            'password.required' => 'Password is required.',
//            'email.exists' => Lang::get("error.invalid_email"),
//            'failed' => 'ee'
//        ];

        $rules = [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users|string|max:255|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            'password' => 'required|string|min:8|confirmed',
        ];
        if ($data['role_id'] == UserRole::COMPANY) {
            $rules = array_merge($rules, [
                'organization_name' => 'required|string|max:255',
            ]);
        } elseif ($data['role_id'] == UserRole::EMPLOYEE) {
            $companyCode = $data['company_code'];

            $rules = array_merge($rules, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'company_code' => ['required', 'string', 'max:255',
                    Rule::exists('partner_organizations')->where(function ($query) use ($companyCode) {
                        $query->whereNotNull('company_code')
                            ->where('company_code', $companyCode);
                    }),],
            ]);
        }

        $validator = Validator::make($data, $rules);

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

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role_id'],
            ]);

            if ($data['role_id'] == UserRole::COMPANY) {
                $companyCode = $this->generateCompanyCode();

                PartnerOrganization::create([
                    'user_id' => $user->id,
                    'company_code' => $companyCode,
                    'organization_name' => $data['organization_name'],
//                    'organization_legal_type' => $data['organization_legal_type'],
//                    'registration_number' => $data['registration_number'],
                ]);
            } else if ($data['role_id'] == UserRole::EMPLOYEE) {
                $partnerOrg = PartnerOrganization::where('company_code', $data['company_code'])->first();
                PartnerPerson::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'patronymic_name' => $data['patronymic_name'],
                    'position' => $data['position'],
                    'company_code' => $partnerOrg->company_code,

                    'user_id' => $user->id,
                    'partner_organization_id' => $partnerOrg->id,
                    // Assign other fields from the request data
                ]);
            }
            $user->notify(new CustomVerifyEmailNotification());
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
//            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * @return string
     */
    private function generateCompanyCode(): string
    {
        do {
            $code = Str::random(6); // Adjust the length as needed
        } while (PartnerOrganization::where('company_code', $code)->exists());

        return $code;
    }

}

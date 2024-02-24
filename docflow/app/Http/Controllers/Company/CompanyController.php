<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function show()
    {
        // Get the logged-in company
        $user = Auth::user();

        $id = $user->partnerOrganization->id;

        $partnerOrganization = PartnerOrganization::findOrFail($id);
        $partnerPersons = $partnerOrganization->partnerPersons;

        return view('profile.employee.index', compact('partnerPersons'));
    }
}

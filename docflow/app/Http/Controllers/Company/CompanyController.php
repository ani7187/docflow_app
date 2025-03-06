<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\partnerOrganization\PartnerOrganization;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $id = $user->partnerOrganization->id;

        $partnerOrganization = PartnerOrganization::findOrFail($id);
        $partnerPersons = $partnerOrganization->partnerPersons;

        foreach ($partnerPersons as $key => $partnerPerson) {
            $user = User::findOrFail($partnerPerson->user_id);
            $partnerPersons[$key]["user"]["email"] = $user["email"];
        }

        return view('admin.employee.index', compact('partnerPersons'));
    }

    public function generatePDF()
    {
        $user = Auth::user();
        if (!empty($user->partnerOrganization)) {
            $id = $user->partnerOrganization->id;
        }

        $partnerOrganization = PartnerOrganization::findOrFail($id);
        $partnerPersons = $partnerOrganization->partnerPersons;

        $partnerPersonList = [];
        foreach ($partnerPersons as $key => $partnerPerson) {
            $user = User::findOrFail($partnerPerson->user_id);
            $partnerPersons[$key]["user"]["email"] = $user["email"];

            $partnerPersonList[] = array(
                "first_name" => $partnerPerson["first_name"],
                "last_name" => $partnerPerson["last_name"],
                "patronymic_name" => $partnerPerson["patronymic_name"],
                "position" => $partnerPerson["position"],
                "created_at" => $partnerPerson["created_at"],
                "email" => $user["email"]
            );

        }

//        dd($partnerPersonList);
        $title = "employee_list";

        $dompdf = new Dompdf();
        $options = new Options();

        $options->set('isPhpEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('fontDir', public_path('fonts/')); // Path to the directory containing font files
        $options->set('defaultFont', 'sylfaen'); // Name of your Armenian font file without extension

        $dompdf->setOptions($options);
        $html = view('pdf.employee', compact("title", "partnerPersonList"));
        $dompdf->loadHtml($html, "UTF-8");
        $dompdf->render();

        return $dompdf->stream('employee_list.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
class TCPDFController extends Controller
{
    public function downloadPdf(Request $request){
        //TCPDF::SetPrintHeader(false);
        //TCPDF::SetPrintFooter(false);
        $certificate = 'file://'.base_path().'/storage/app/certificate/Doc.crt';
        // set additional information in the signature
        $info = array(
            'Name' => 'Kaushal Kushwaha',
            'Location' => 'Indore',
            'Reason' => 'Generate Demo TCPDF',
            'ContactInfo' => '',
        );
//        TCPDF::setSignature($certificate, $certificate, 'tcTCPDFdemo', '', 2, $info);
//        TCPDF::SetFont('helvetica', '', 12);
//        TCPDF::Set
        TCPDF::Cell(1,2, 'Digitali signed by:', 10, 1);
        TCPDF::SetCreator('Kaushal Kushwaha');
        TCPDF::SetTitle('new-TCPDF');
        TCPDF::SetAuthor('Kaushal');
        TCPDF::SetSubject('Generated TCPDF');
        TCPDF::AddPage();
        $html = '<div>
            <h1>What is Lorem Ipsum?</h1>
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s,
            when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            It has survived not only five centuries, but also the leap into electronic typesetting,
            remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
            sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like
            Aldus PageMaker including versions of Lorem Ipsum.
        </div>';
        TCPDF::writeHTML($html, true, false, true, false, '');
        //TCPDF::Image('kaushalkushwaha.png', 5, 75, 40, 15, 'PNG');
//        TCPDF::setSignatureAppearance(5, 75, 40, 15);
        TCPDF::Output(public_path('digital-signed-PDF.PDF'), 'F');
        TCPDF::reset();
        echo "TCPDF Generated Successfully";
    }}

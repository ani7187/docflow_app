<?php

namespace App\Http\Controllers;

use App\Models\document\Document;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Mpdf\Mpdf;
use Psy\Util\Str;
use Smalot\PdfParser\Parser;

class PDFSignatureController extends Controller
{
    public function generatePDFWithSignature($filePath="C:\OSPanel\domains\diplom\docflow\storage\app\documents\\47\\file.pdf", $name = "", $docID = 167)/*="C:\OSPanel\domains\diplom\docflow\storage\app\documents\\30\\file.pdf"*/
    {
        // Load TCPDF configuration
        $config = config('tcpdf_signature_config');

        // Create a new TCPDF instance
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document properties
        $pdf->SetCreator(config('app.name'));
        $pdf->SetAuthor(Auth::user()->name);
        $pdf->SetTitle($name);
        $pdf->SetSubject('Digital Signature Example');
        $pdf->SetKeywords('laravel, pdf, digital signature');

        $pdf->SetProtection(array('modify', 'annot-forms', 'fill-forms'),null,null, 0, 0);
        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set margins
        $pdf->SetMargins(25, 25, 10);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 10);

        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Initialize PDF document
        $pdf->AddPage();

        // Output digital signature image
        if (!empty($config['signature_file'])) {
            $signatureX = $config['signature_coordinates']['x'];
            $signatureY = $config['signature_coordinates']['y'];
            $pdf->Image($config['signature_file'], $signatureX, $signatureY, $config['signature_image_width'], $config['signature_image_height']);
        }

//        $font = $pdf->AddFont(public_path('fonts\freeserif.ttf'), '', '', 32);
//        dd($font);
//        $pdf->SetFont($font, '', 12);

//        $encryptedContents = file_get_contents($filePath);
//        $decryptedContents = Crypt::decrypt($encryptedContents);

//        dd($decryptedContents);

        $filePath = $this->decr($filePath);
//        dd($filePath);
        $parser = new Parser();

        // Extract text from PDF file
        $pdfFile = $parser->parseFile($filePath);
        $text = $pdfFile->getText();
        $html = '<div>' . nl2br(htmlspecialchars($text)) . '</div>';
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output text for digital signature
//        $pdf->SetFont('Helvetica', '', '12');
        $pdf->SetXY(150, 100);
        $pdf->Cell(0, 0, 'Signed by:', 0, 1);
        $pdf->SetXY(150, 105);
        $pdf->Cell(0, 0, "Ani Azizyan", 0, 1);
        $pdf->SetXY(150, 110);
        $pdf->Cell(0, 0, 'Date: ' . date('Y-m-d H:i:s'), 0, 1);


        $pdfDirectory = storage_path('app/documents/tmp');

        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0777, true); // Create directory recursively
        }

        $filename = "Ստորագրված_" . $name;
        $pdfPath = $pdfDirectory . '/' . $filename;
//        dd($pdfPath);

//        $file = Crypt::encrypt(file_get_contents($filePath));

        $pdf->Output($pdfPath, 'I');

        $document = Document::findOrFail($docID);
        $document->addMedia($pdfPath)->toMediaCollection('files', 'documents');

        unlink($filePath);
    }

    protected function decr($filePath){

        $encryptedContents = file_get_contents($filePath);
        $decryptedContent = Crypt::decrypt($encryptedContents);

        $pdfDirectory = storage_path('app/documents/tmp');
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0777, true); // Create directory recursively
        }

        $filename = \Illuminate\Support\Str::uuid();
        $pdfPath = $pdfDirectory . '/' . $filename.".pdf";
        file_put_contents($pdfPath, $decryptedContent);

        return $pdfPath;
    }
}

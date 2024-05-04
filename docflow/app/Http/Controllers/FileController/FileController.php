<?php

namespace App\Http\Controllers\FileController;

use App\Http\Controllers\Controller;
use getID3;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\PdfToText\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class FileController extends Controller
{
    public function download(Media $media)
    {
        $file = storage_path('app\\documents\\' . $media->id . '\\' . $media->file_name);
        $fileName = $media->file_name;

        $encryptedContents = file_get_contents($file);
        $decryptedContents = Crypt::decrypt($encryptedContents);

        return Response::streamDownload(function () use ($decryptedContents) {
            echo $decryptedContents;
        }, $fileName);
    }

    public function downloadAll(Media $media)
    { //todo
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir);
        }

        $mediaId = $media->id;


        $zipPath = $tempDir . '/media_' . $mediaId . '.zip';
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($media->files as $file) {
                $filePath = storage_path('app/documents/' . $file->id . '/' . $file->file_name);
                $fileName = $file->file_name;
                $zip->addFile($filePath, $fileName);
            }
            $zip->close();
        } else {
            // Handle error opening the zip archive
            return response()->json(['error' => 'Failed to create zip archive'], 500);
        }

        // Generate a streamed response for downloading the zip file
        $response = new StreamedResponse(function () use ($zipPath) {
            readfile($zipPath);
        });
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment; filename="media_' . $mediaId . '.zip"');

        // Clean up the temporary directory
        unlink($zipPath);
        rmdir($tempDir);

        return $response;
    }


    public function getMetadata() {
        $pdfFilePath = storage_path('app/documents/tmp');
        $file = $pdfFilePath."/"."12.pdf";

        /*$getID3 = new getID3;

        $fileInfo = $getID3->analyze($file);
        $pdfMetadata = $fileInfo['pdf'];

        dd($pdfMetadata);
// Output the metadata
        echo "Title: " . $pdfMetadata['title'] . "\n";
        echo "Author: " . $pdfMetadata['author'] . "\n";
        echo "Subject: " . $pdfMetadata['subject'] . "\n";
        echo "Keywords: " . implode(', ', $pdfMetadata['keywords']) . "\n";*/


        if (!$fp = fopen($file, 'r')) {
            trigger_error("Unable to open URL ($file)", E_USER_ERROR);
        }

        $meta = stream_get_meta_data($fp);

        dd($meta);

        fclose($fp);
    }


    public function signDocument()
    {
        $pdfFilePath = storage_path('app/documents/tmp');
        $file = $pdfFilePath."/"."12.pdf";
        // Retrieve user ID and document content from the request
//        $userId = $request->input('user_id');
//        $documentContent = $request->input('document_content');

        $documentContent = file_get_contents($file);
        // Generate a unique file name for the document
        $fileName = uniqid('document_') . '.pdf';

        // Sign the document content using the user's private key
        $digitalSignature = $this->generateDigitalSignature(48, $documentContent);

        // Save the signed document and digital signature
        Storage::put('signed_documents/' . $fileName, $documentContent);
        Storage::put('digital_signatures/' . $fileName . '.signature', $digitalSignature);

        dd($digitalSignature);
        return response()->json(['message' => 'Document signed successfully']);
    }

    public function verifySignature()
    {
        // Retrieve file name from the request
//        $fileName = $request->input('file_name');
        $fileName = "document_662d1bebb2d06.pdf";
        // Retrieve the signed document and digital signature
        $documentContent = Storage::get('signed_documents/' . $fileName);
        $digitalSignature = Storage::get('digital_signatures/' . $fileName . '.signature');

        // Retrieve user ID from the document metadata or request
//        $userId = $request->input('user_id');

        // Verify the digital signature using the user's public key
        $isSignatureValid = $this->verifyDigitalSignature(48, $documentContent, $digitalSignature);

        if ($isSignatureValid) {
            return response()->json(['message' => 'Digital signature verified successfully']);
        } else {
            return response()->json(['error' => 'Invalid digital signature'], 400);
        }
    }

    private function generateDigitalSignature($userId, $documentContent)
    {
        // Retrieve user's private key from secure storage (e.g., database)
        $privateKeyPath = storage_path('app/private.pem');
        $privateKey = file_get_contents($privateKeyPath);
//        dd($privateKey);
        // Use a cryptographic library (e.g., OpenSSL) to sign the document content
        $signature = openssl_sign($documentContent, $digitalSignature, $privateKey, OPENSSL_ALGO_SHA256);

        // Return the digital signature
        return $digitalSignature;
    }

    private function verifyDigitalSignature($userId, $documentContent, $digitalSignature)
    {
        // Retrieve user's public key from secure storage (e.g., database)
        $publicKeyPath = storage_path('app/public.pem');
        $publicKey = file_get_contents($publicKeyPath);

        // Use a cryptographic library (e.g., OpenSSL) to verify the digital signature
        $isSignatureValid = openssl_verify($documentContent, $digitalSignature, $publicKey, OPENSSL_ALGO_SHA256);

        // Return true if the signature is valid, false otherwise
        return $isSignatureValid === 1;
    }


    public function getSecret() {

// Your Vault server URL
        $vaultUrl = 'http://portal.cloud.hashicorp.com/';

// Client ID and secret for authentication
//        $clientId = 'kB5yS91zp5MnWvKZ11AJK6yJhq0m6MHj';
//        $clientSecret = '4Nvxo3uN0_AF9eDDXxlpxLOC37J10HODXCNBUWdJk8do3_QR_rxZ4sRyRqXVyKyM';

        $clientId = "CcRRdTu80Jv3TAoeb3dtjtk5ua8Hfdb4";
        $clientSecret = "98noaC-TYbDICvy60WpaPjHBua2UOwAqJ1DwpDpYMGx7TJbqR93yrmziURsRdM7E";

//        config([
//            'http.ssl.certificate_authority' => storage_path('cacert.pem'),
//        ]);
//
//        $response = Http::asForm()->post('https://auth.idp.hashicorp.com/oauth2/token', [
//            'client_id' => $clientId,
//            'client_secret' => $clientSecret,
//            'grant_type' => 'client_credentials',
//            'audience' => 'https://api.hashicorp.cloud',
//        ]);



// Check if the request was successful
//        if ($response->successful()) {
//            // Parse the JSON response and extract the access token
//            $accessToken = $response->json('access_token');
//            dd($accessToken); // Output the access token
//        } else {
//            // Handle non-successful response
//            echo 'Failed to obtain access token: ' . $response->body();
//        }

// Authenticate with Vault using client ID and secret
//        $response = Http::post("$vaultUrl/v1/auth/{approle}/login", [
//            'client_id' => $clientId,
//            'client_secret' => $clientSecret,
//        ]);

//        dd($response);
// Extract the Vault token from the response
//        $token = $response->json('auth.client_token');
            $token = "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik1VRTNPRFE0UkVGRU1ESXhRemczT0VFNU5UazROalJHT0RnME5qSTRNRGc1TjBNeVJqVXlSUSJ9.eyJpc3MiOiJodHRwczovL2F1dGguaGFzaGljb3JwLmNvbS8iLCJzdWIiOiJDY1JSZFR1ODBKdjNUQW9lYjNkdGp0azV1YThIZmRiNEBjbGllbnRzIiwiYXVkIjoiaHR0cHM6Ly9hcGkuaGFzaGljb3JwLmNsb3VkIiwiaWF0IjoxNzE0NDEwNjcwLCJleHAiOjE3MTQ0MTQyNzAsImd0eSI6ImNsaWVudC1jcmVkZW50aWFscyIsImF6cCI6IkNjUlJkVHU4MEp2M1RBb2ViM2R0anRrNXVhOEhmZGI0In0.WEiq8o7aWV8NaEj0boOh0c05BVrCL30gTrDg2txXV7emO08fAR2WtZxgOrEG9hHAm7-DleVx8lpUnHI1EzUuwz3plpQgGHENBt6HRmd_DcdmVYa9AHtDS9wU118Hk9EDiYCsrfgiJw5KkfOo4rUi5_VG4-4fz7zAk5s_wFLrJGHQQJ650JWqwwnYZlbqN3sLva3fhCsj8VQSJpSL1r8DoY_JYezbe1BQZ1qoGwaJBLRqBS6E8hqWQbQ_H6Hjlocnom3ky3w_sbqF977TfLWDX4vm8fGfmjhYFzWH2BTjS_jD7b83o_ITWrbw_adMiZ9GCFJrmF47BsiAPQpu-1Hjxw";

//        dd($token);
// Use the obtained token to retrieve the secret
        $response = Http::withToken($token)->get("https://portal.cloud.hashicorp.com/v1/secrets/apps/sample-app/secret/");

// Extract the secret data from the response
        $secretData = $response->json('data.data');

// Use the secret data as needed

    }
}

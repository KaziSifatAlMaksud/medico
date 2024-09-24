<?php

namespace App\Http\Controllers\certificate;

use App\Http\Controllers\Controller;
use App\Models\CertificatePrice;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\MedicalCertificate;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade as Pdf;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class CertificateController extends Controller
{
    public function index()
    {
        // Retrieve the currently authenticated user
        $user = auth()->user();

        // Retrieve the medical certificate for the authenticated user
        $certificate = MedicalCertificate::where('user_id', $user->id)->first();

        $price = CertificatePrice::first();

        // Check if the user has a certificate
        if ($certificate) {
            // Redirect to payment page if the certificate exists and payment is pending
            if ($certificate->payment === 'pending') {
                return view('website.eCertificate.paymentPage', [
                    'amount' => $price->price, // Use the price from the database
                    'requestData' => $certificate->toArray(), // Convert the certificate to an array
                    'err' => 'You already applied for a certificate, and the payment is incomplete.',
                ]);
            }

            // Pass the certificate data to the view
            return view('website.eCertificate.certificate', [
                'certificate' => $certificate
            ]);
        } else {
            return view('website.eCertificate.certificate', [
                'certificate' => $certificate
            ]);
        }
    }

    public function generateCertificate()
    {
        // Fetch the authenticated user's data
        $user = auth()->user();

        // Fetch available languages
        $languages = Language::where('status', 1)->get();

        // Pass data to the view
        return view('website.eCertificate.certificate_index', compact('user', 'languages'));
    }

    public function storeCertificate(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'gender' => 'required|string',
                'issues' => 'required|string',
                'address' => 'required|string',
                'medical_attention_days' => 'required|string',
                'prescription' => 'required|image|mimes:jpeg,png,jpg',
            ]);

            // Get authenticated user
            $user = auth()->user();

            // Check if the user already has a certificate
            $existingCertificate = MedicalCertificate::where('user_id', $user->id)->first();
            if ($existingCertificate) {
                return redirect()->back()->with('err', 'You have already generated a certificate.');
            }

            // Handle file upload
            $filePath = null;
            if ($request->hasFile('prescription')) {
                $file = $request->file('prescription');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('public/images/certificate', $fileName);
            }

            // Create a new medical certificate record
            MedicalCertificate::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'issues' => $request->issues,
                'address' => $request->address,
                'medical_attention_days' => $request->medical_attention_days,
                'prescription' => $filePath ? str_replace('public/', 'storage/', $filePath) : null,
                'payment' => 'pending', // Assuming payment status is 'pending' initially
            ]);

            $price = CertificatePrice::first();


            // Redirect to payment page with required data
            return view('website.eCertificate.paymentPage', [
                'amount' => $price->price, // Use the price from the database
                'requestData' => $request->all(),
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing certificate: ' . $e->getMessage());
            return redirect()->back()->with('err', 'An error occurred while generating the certificate. Please try again.');
        }
    }

    public function confirmPayment(Request $request)
    {
        // Extract payment method from request data
        $paymentMethod = $request->input('payment_method');

        // Find the certificate record
        $certificate = MedicalCertificate::where('user_id', auth()->user()->id)
            ->where('payment', 'pending')
            ->first();

        if (!$certificate) {
            return redirect()->back()->with('error', 'Certificate not found or payment already processed.');
        }

        // Perform payment processing depending on the payment method
        if ($paymentMethod === 'stripe') {
            // Handle Stripe payment processing
            $paymentStatus = $this->processStripePayment($request);
        } elseif ($paymentMethod === 'razorpay') {
            // Handle Razorpay payment processing
            $paymentStatus = $this->processRazorpayPayment($request);
        } else {
            return redirect()->back()->with('error', 'Invalid payment method.');
        }

        // Check if payment was successful
        if ($paymentStatus['success']) {
            // Update payment status in the certificate record
            $certificate->update(['payment' => 'completed']);

            // Redirect to the certificate index page with a success message
            return redirect()->route('certificate.index')->with('success', 'Certificate generated successfully.');
        } else {
            // Redirect back to the payment page with an error message
            return redirect()->back()->with('error', 'Payment failed. Please try again.');
        }
    }

    // Example payment processing methods
    protected function processStripePayment($request)
    {
        // Implement Stripe payment logic here
        // Example response
        return ['success' => true, 'message' => 'Payment successful.'];
    }

    protected function processRazorpayPayment($request)
    {
        // Implement Razorpay payment logic here
        // Example response
        return ['success' => true, 'message' => 'Payment successful.'];
    }

    /**
     * Convert an image file to a base64 encoded string.
     *
     * @param string $imagePath
     * @return string
     */
    protected function convertImageToBase64($imagePath)
    {
        // Ensure file exists
        if (!file_exists($imagePath)) {
            return '';
        }

        // Get the file's mime type
        $mimeType = mime_content_type($imagePath);

        // Get the file's contents
        $imageData = file_get_contents($imagePath);

        // Encode the image data to base64
        $base64 = base64_encode($imageData);

        // Return the base64 string with the mime type
        return 'data:' . $mimeType . ';base64,' . $base64;
    }

    public function downloadCertificate($id)
    {
        // Fetch the certificate based on the user ID
        $certificate = MedicalCertificate::where('user_id', $id)->first();

        // Check if the certificate exists
        if (!$certificate) {
            return redirect()->back()->with('err', 'Certificate not found.');
        }

        // Convert images to base64
        $logoImage = $this->convertImageToBase64(public_path('images/laravel.png'));
        $stampImage = $this->convertImageToBase64(public_path('images/stmp.png'));
        $signatureImage = $this->convertImageToBase64(public_path('images/sig.png'));

        // Prepare the data to pass to the PDF view
        $data = [
            'name' => $certificate->name,
            'address' => $certificate->address,
            'issues' => $certificate->issues,
            'medical_attention_days' => $certificate->medical_attention_days,
            'prescription_image' => $certificate->prescription,
            'date' => $certificate->created_at->format('d/m/y'),
            'logo_image' => $logoImage,
            'stamp_image' => $stampImage,
            'signature_image' => $signatureImage,
        ];

        // dd($data);
        // Load the view and pass the data
        // $pdf = FacadePdf::loadView('website.eCertificate.certificatePDF', $data);

        $pdf = FacadePdf::loadView('website.eCertificate.certificatePDF', $data)
            ->setPaper('a4', 'portrait '); // Set paper size and orientation
        // Stream the PDF file to the browser
        return $pdf->stream('certificate.pdf');
    }
}

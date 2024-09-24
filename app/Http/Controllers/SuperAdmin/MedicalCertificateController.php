<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\CertificatePrice;
use App\Models\MedicalCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MedicalCertificateController extends Controller
{

    public function index()
    {
        if (Gate::denies('certificate_view')) {
            abort(403, 'Unauthorized action.');
        }

        // Get the first CertificatePrice record
        $price = CertificatePrice::first();

        // Retrieve certificates with status '0'
        $certificates = MedicalCertificate::where('status', '0')->get();

        // Pass both $certificates and $price to the view
        return view('superAdmin.certificate.certificate_list', [
            'certificates' => $certificates,
            'price' => $price
        ]);
    }
    public function send($id)
    {
        $certificate = MedicalCertificate::findOrFail($id);
        $certificate->status = 'send';
        $certificate->save();

        return redirect()->back()->with('success', 'Certificate status updated to "send".');
    }

    public function delete($id)
    {
        $certificate = MedicalCertificate::findOrFail($id);
        $certificate->status = 'delete';
        $certificate->save();

        return redirect()->back()->with('success', 'Certificate status updated to "delete".');
    }


    public function update(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $price = CertificatePrice::first();
        if ($price) {
            $price->update(['price' => $request->price]);
        } else {
            CertificatePrice::create(['price' => $request->price]);
        }

        return redirect()->back()->with('success', 'Price updated successfully.');
    }
}

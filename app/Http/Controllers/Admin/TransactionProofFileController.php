<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Add this line

class TransactionProofFileController extends Controller
{
    public function show(string $filename)
    {
        // Clean the filename from any directory traversal
        $filename = basename($filename);
        
        // Try proofs_private directory first (for TransactionProof model)
        $privatePath = 'proofs_private/' . $filename;
        if (Storage::disk('local')->exists($privatePath)) {
            return Storage::disk('local')->response($privatePath);
        }
        
        // Try proofs directory in public disk (for Membership payment_proof)
        $publicPath = 'proofs/' . $filename;
        if (Storage::disk('public')->exists($publicPath)) {
            return Storage::disk('public')->response($publicPath);
        }

        abort(404, 'File not found');
    }
}

<?php

namespace Database\Seeders;

use App\Models\TransactionProof;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TransactionProofSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure proofs_private directory exists
        Storage::disk('local')->makeDirectory('proofs_private');

        // Create sample proof files (just text files for testing)
        $proofFiles = [
            'proof_1.txt' => 'Sample proof 1 content',
            'proof_2.txt' => 'Sample proof 2 content', 
            'proof_3.txt' => 'Sample proof 3 content',
            'proof_4.txt' => 'Sample proof 4 content',
            'proof_5.txt' => 'Sample proof 5 content',
        ];

        foreach ($proofFiles as $filename => $content) {
            Storage::disk('local')->put('proofs_private/' . $filename, $content);
        }

        // Get existing memberships and users
        $memberships = Membership::with('user')->get();
        
        if ($memberships->count() === 0) {
            echo "No memberships found. Please create memberships first.\n";
            return;
        }

        $sampleNotes = [
            'Pembayaran melalui transfer bank',
            'Bayar via e-wallet DANA',
            'Transfer melalui ATM BCA',
            'Pembayaran tunai di gym',
            null, // No notes
        ];

        // Create transaction proofs for existing memberships
        foreach ($memberships->take(5) as $index => $membership) {
            TransactionProof::create([
                'user_id' => $membership->user_id,
                'membership_id' => $membership->id,
                'proof_path' => 'proofs_private/' . array_keys($proofFiles)[$index],
                'status' => 'approved',
                'notes' => $sampleNotes[$index],
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(0, 5)),
            ]);
        }

        echo "Created 5 approved transaction proofs.\n";
    }
}

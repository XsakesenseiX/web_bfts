<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\MembershipPackage;

class SyncMembershipTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-membership-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync membership package types with user status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::with('memberships.package')->get();

        foreach ($users as $user) {
            $this->info("Checking user: {$user->name} (Status: {$user->status})");

            foreach ($user->memberships as $membership) {
                if (!$membership->package) {
                    $this->warn("  Membership ID {$membership->id} has no associated package. Skipping.");
                    continue;
                }

                $expectedPackageType = ($user->status === 'mahasiswa') ? 'student' : 'regular';

                if ($membership->package->type !== $expectedPackageType) {
                    $this->error("  Mismatch found for Membership ID {$membership->id} (Package: {$membership->package->name}, Type: {$membership->package->type}). Expected type: {$expectedPackageType}.");
                    $this->warn("    Consider manually updating this membership or guiding the user to purchase a new package.");
                } else {
                    $this->info("  Membership ID {$membership->id} (Package: {$membership->package->name}, Type: {$membership->package->type}) matches user status.");
                }
            }
        }

        $this->info('\nMembership type sync check complete. Please review the output for any mismatches.');
    }
}
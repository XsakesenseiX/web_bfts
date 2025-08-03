<?php

namespace App\Filament\Member\Pages;

use Filament\Pages\Page;
use App\Models\MembershipPackage;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use App\Models\Membership;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Carbon\Carbon;

class PurchasePackage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static string $view = 'filament.member.pages.purchase-package';
    protected static ?string $title = 'Konfirmasi Pembelian';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $routePath = '/purchase/{package}';

    public MembershipPackage $package;
    public ?array $data = [];
    public int $additionalFee = 0;
    public int $totalPrice = 0;

    // PERBAIKAN DI SINI
    public function mount(): void
    {
        // 1. Ambil ID paket secara manual dari URL yang sedang aktif
        $packageId = request()->route('package');
        
        // 2. Cari datanya di database menggunakan ID tersebut
        $this->package = MembershipPackage::findOrFail($packageId);

        // 3. Lanjutkan sisa logika seperti biasa
        $user = Auth::user();
        $lastActiveMembership = $user->memberships()
                                    ->where('status', 'active')
                                    ->latest('end_date')
                                    ->first();

        if (!$lastActiveMembership || Carbon::parse($lastActiveMembership->end_date)->addMonths(3)->isPast()) {
            $this->additionalFee = 40000;
        }

        $this->totalPrice = $this->package->price + $this->additionalFee;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('payment_proof')
                    ->label('Unggah Bukti Transfer (JPG, PNG)')
                    ->image()
                    ->maxSize(2048)
                    ->required()
                    ->directory('proofs'),
            ])
            ->statePath('data');
    }

    public function purchase()
    {
        $this->form->validate();
        $paymentProofPath = null;
        if (!empty($this->data['payment_proof'])) {
            $paymentProofPath = $this->data['payment_proof'][0];
        }

        Membership::create([
            'user_id' => Auth::id(),
            'membership_package_id' => $this->package->id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays($this->package->duration_days),
            'status' => 'pending',
            'payment_proof' => $paymentProofPath,
        ]);
        Notification::make()->title('Permintaan pembelian berhasil dikirim!')->success()->send();
        return redirect()->to(MemberDashboard::class);
    }
}
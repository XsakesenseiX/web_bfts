<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipResource\Pages;
use App\Models\Membership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;
    protected static ?string $navigationLabel = 'Verifikasi Pembayaran';
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?int $navigationSort = 20;

    

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('status', 'pending'))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama Member')->searchable(),
                Tables\Columns\TextColumn::make('package.name')->label('Paket'),
                Tables\Columns\TextColumn::make('payment_proof')
                    ->label('Bukti Bayar')
                    ->formatStateUsing(fn ($state) => $state ? 'Lihat Bukti' : 'Tidak Ada')
                    ->url(fn (Membership $record): ?string => $record->payment_proof 
                        ? route('admin.transaction-proofs.show', ['filename' => basename($record->payment_proof)]) 
                        : null
                    )
                    ->color(fn ($state) => $state ? 'primary' : 'gray')
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Beli')->dateTime()->sortable(),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Setujui')
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->action(function (Membership $record) {
                        $user = $record->user;
                        $newPackage = $record->package;
                        $activeMembership = $user->memberships()->where('status', 'active')->first();

                        // Create TransactionProof record upon approval FIRST
                        if ($record->payment_proof) {
                            \App\Models\TransactionProof::create([
                                'user_id' => $record->user_id,
                                'membership_id' => $record->id,
                                'proof_path' => $record->payment_proof,
                                'status' => 'approved',
                                'notes' => 'Approved by admin.',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }

                        if ($activeMembership) {
                            // Extend existing active membership
                            $newEndDate = Carbon::parse($activeMembership->end_date)->addDays($newPackage->duration_days);
                            $activeMembership->update(['end_date' => $newEndDate]);
                            // Delete the pending membership since we merged it with active one
                            $record->delete();
                        } else {
                            // Activate the pending membership
                            $record->update([
                                'status' => 'active',
                                'start_date' => Carbon::now(),
                                'end_date' => Carbon::now()->addDays($newPackage->duration_days),
                                'payment_proof' => null,
                                'updated_at' => now(),
                            ]);
                        }
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('Membership berhasil diaktifkan/diperpanjang.'),
                Action::make('reject')
                    ->label('Tolak')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->action(fn (Membership $record) => $record->delete())
                    ->requiresConfirmation(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemberships::route('/'),
        ];
    }    

    protected static function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        return null;
    }    
}
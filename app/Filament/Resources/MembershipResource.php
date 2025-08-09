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

    protected static ?string $navigationGroup = 'Verifikasi';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

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
                    ->formatStateUsing(fn () => 'Lihat Bukti') // Menampilkan teks "Lihat Bukti"
                    ->url(fn (Membership $record): string => Storage::url($record->payment_proof)) // Membuat link ke file
                    ->openUrlInNewTab(), // Membuka link di tab baru
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

                        if ($activeMembership) {
                            $newEndDate = Carbon::parse($activeMembership->end_date)->addDays($newPackage->duration_days);
                            $activeMembership->update(['end_date' => $newEndDate]);
                            $record->delete();
                        } else {
                            $record->update([
                                'status' => 'active',
                                'start_date' => Carbon::now(),
                                'end_date' => Carbon::now()->addDays($newPackage->duration_days),
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
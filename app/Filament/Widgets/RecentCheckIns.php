<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\CheckIn;
use Carbon\Carbon;
use Filament\Forms;

class RecentCheckIns extends BaseWidget
{
    protected static ?string $pollingInterval = '5s';
    protected static ?int $sort = 2; // Urutan widget di dashboard
    protected int | string | array $columnSpan = 'full'; // Agar widget ini memakan lebar penuh

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Ambil data check-in hari ini saja
                CheckIn::query()->whereDate('created_at', Carbon::today())
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama Member')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Waktu Check-in')->time(),
                Tables\Columns\TextColumn::make('locker_number')->label('No. Loker')
                    ->badge()
                    ->color('warning')
                    ->placeholder('Tidak pakai'),
            ])
            ->actions([
                // Tambahkan aksi untuk mengatur loker langsung dari tabel
                Tables\Actions\EditAction::make('setLocker')
                    ->label('Atur Loker')
                    ->form([
                        Forms\Components\TextInput::make('locker_number')
                            ->label('Nomor Loker')
                            ->required(),
                        Forms\Components\Toggle::make('uses_locker')
                            ->default(true)
                            ->hidden(),
                    ])
            ]);
    }
}
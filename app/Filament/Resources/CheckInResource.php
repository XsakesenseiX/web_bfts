<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckInResource\Pages;
use App\Models\CheckIn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class CheckInResource extends Resource
{
    protected static ?string $model = CheckIn::class;
    protected static ?string $navigationLabel = 'Laporan Pengunjung';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama Member')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('Waktu Check-in')->time(),
                Tables\Columns\TextColumn::make('locker_number')->label('No. Loker')
                    ->badge()
                    ->color('primary')
                    ->placeholder('Tidak pakai loker'),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->default([
                        'created_from' => Carbon::today(),
                        'created_until' => Carbon::today(),
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form([
                    Forms\Components\TextInput::make('locker_number')
                        ->required()
                        ->maxLength(10),
                    Forms\Components\Toggle::make('uses_locker')
                        ->default(true)
                        ->hidden(),
                ])->label('Atur Loker'),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCheckIns::route('/'),
        ];
    }    
}
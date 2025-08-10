<?php

namespace App\Filament\Resources\UserResource\RelationManagers;


use App\Models\MembershipPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembershipsRelationManager extends RelationManager
{
    protected static string $relationship = 'memberships';

    protected static ?string $pollingInterval = '5s';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('membership_package_id')
                    ->label('Paket Membership')
                    ->options(MembershipPackage::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('Tanggal Selesai')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'pending' => 'Pending',
                        'expired' => 'Expired',
                    ])
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('package.name')->label('Paket'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'pending' => 'warning',
                        'expired' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('start_date')->date('d M Y'),
                Tables\Columns\TextColumn::make('end_date')->date('d M Y'),
                Tables\Columns\TextColumn::make('remaining_check_ins')
                    ->label('Sisa Check In')
                    ->getStateUsing(function ($record) {
                        return $record->package->check_in_limit - $record->check_ins_made;
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('edit_membership')
                    ->label('Ubah Membership')
                    ->form([
                        Forms\Components\TextInput::make('remaining_days')
                            ->label('Sisa Hari')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('remaining_check_ins')
                            ->label('Sisa Check In')
                            ->numeric()
                            ->required(),
                    ])
                    ->action(function (array $data, $record) {
                        $checkInLimit = $record->package->check_in_limit;
                        $newCheckInsMade = $checkInLimit - $data['remaining_check_ins'];

                        $record->update([
                            'end_date' => now()->addDays($data['remaining_days']),
                            'check_ins_made' => $newCheckInsMade,
                        ]);

                        
                    }),
            ]);
    }

    
}

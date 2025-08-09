<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipPackageResource\Pages;
use App\Models\MembershipPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MembershipPackageResource extends Resource
{
    protected static ?string $model = MembershipPackage::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Manajemen Paket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('duration_days')
                    ->required()
                    ->numeric()
                    ->suffix('hari'),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->options([
                        'regular' => 'Regular',
                        'student' => 'Student',
                        'loyalty' => 'Loyalty',
                    ])
                    ->required()
                    ->reactive(),
                Forms\Components\TextInput::make('check_in_limit')
                    ->numeric()
                    ->label('Batas Check-in (untuk Loyalty Card)')
                    ->hidden(fn (Forms\Get $get) => $get('type') !== 'loyalty')
                    ->required(fn (Forms\Get $get) => $get('type') === 'loyalty'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('price')->money('IDR')->sortable(),
                Tables\Columns\TextColumn::make('duration_days')->suffix(' hari')->sortable(),
                Tables\Columns\TextColumn::make('check_in_limit')->label('Batas Check-in')->placeholder('-'),
                Tables\Columns\TextColumn::make('type')->label('Tipe')->badge(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembershipPackages::route('/'),
            'create' => Pages\CreateMembershipPackage::route('/create'),
            'edit' => Pages\EditMembershipPackage::route('/{record}/edit'),
        ];
    }    

    protected static function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        return null;
    }    
}
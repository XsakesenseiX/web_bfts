<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonalTrainerResource\Pages;
use App\Models\PersonalTrainer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PersonalTrainerResource extends Resource
{
    protected static ?string $model = PersonalTrainer::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Manajemen Trainer';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->directory('trainers'),
                Forms\Components\Textarea::make('specialties')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('contact_info')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Masukkan nomor WhatsApp tanpa +62 atau 0 di depan, contoh: 81234567890'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('age')->label('Umur')->sortable(),
                Tables\Columns\TextColumn::make('specialties')->limit(50),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPersonalTrainers::route('/'),
            'create' => Pages\CreatePersonalTrainer::route('/create'),
            'edit' => Pages\EditPersonalTrainer::route('/{record}/edit'),
        ];
    }    
}
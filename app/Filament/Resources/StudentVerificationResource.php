<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentVerificationResource\Pages;
use App\Filament\Resources\StudentVerificationResource\RelationManagers;
use App\Models\User;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentVerificationResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Verifikasi Mahasiswa';

    protected static ?string $navigationGroup = 'Verifikasi';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'mahasiswa')->where('is_approved', false)->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status', 'mahasiswa')
            ->where('is_approved', false);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                ImageColumn::make('student_id_card_path')
                    ->label('Kartu Mahasiswa')
                    ->url(fn (User $record) => $record->student_id_card_url)
                    ->openUrlInNewTab(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->label('Setujui')
                    ->action(fn (User $record) => $record->update(['is_approved' => true]))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check-circle'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentVerifications::route('/'),
        ];
    }
}

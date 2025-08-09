<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Manajemen Member';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // Memastikan email unik
                Forms\Components\TextInput::make('phone') // Menggunakan nama kolom 'phone' dari migrasi
                    ->tel()
                    ->label('Nomor Telepon'),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        'umum' => 'Umum',
                        'mahasiswa' => 'Mahasiswa',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('student_id_card_path')
                    ->label('Kartu Tanda Mahasiswa')
                    ->image()
                    ->directory('student-id-cards'),
                Forms\Components\Toggle::make('is_approved')
                    ->label('Disetujui')
                    ->required(),
                Forms\Components\Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'member' => 'Member',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('No. Telepon')->searchable(),
                Tables\Columns\TextColumn::make('address')->label('Alamat')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')->label('Status')->searchable(),
                Tables\Columns\ImageColumn::make('student_id_card_path')->label('Kartu Mahasiswa'),
                

                Tables\Columns\TextColumn::make('activeMembership.package.name')
                    ->label('Membership')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger')
                    ->formatStateUsing(function (User $record) {
                        $activeMembership = $record->memberships()->where('status', 'active')->first();
                        return $activeMembership ? 'Aktif' : 'Tidak Aktif';
                    })
                    ->action(Tables\Actions\Action::make('viewMembership')
                        ->label('Lihat Detail')
                        ->modalContent(function (User $record) {
                            $activeMembership = $record->memberships()->where('status', 'active')->first();
                            if ($activeMembership) {
                                $endDate = \Carbon\Carbon::parse($activeMembership->end_date);
                                $remainingDays = now()->diffInDays($endDate, false);
                                return view('filament.admin.memberships.view-membership-details', [
                                    'membership' => $activeMembership,
                                    'remainingDays' => $remainingDays,
                                ]);
                            }
                            return 'Tidak ada membership aktif.';
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Close')
                        ->visible(fn (User $record) => $record->memberships()->where('status', 'active')->exists())
                    ),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'member' => 'success',
                        default => 'gray'
                    }),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RelationManagers\MembershipsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    

    protected static function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        return null;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['memberships.package']);
    }
}
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckInResource\Pages;
use App\Models\CheckIn;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

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
            Tables\Columns\TextColumn::make('created_at')->label('Waktu Check-in')->dateTime('l, d F Y - H:i:s')->sortable(),
            Tables\Columns\TextColumn::make('locker_number')->label('No. Loker')->badge()->color('primary')->placeholder('Tidak pakai loker'),
        ])
        ->filters([
            Filter::make('date')
                ->form([
                    Forms\Components\DatePicker::make('selected_date')->label('Pilih Tanggal'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (isset($data['selected_date']) && !empty($data['selected_date'])) {
                        return $query->whereDate('created_at', $data['selected_date']);
                    } else {
                        // Default to last 1 month if no date is selected
                        return $query->where('created_at', '>=', Carbon::now()->subMonth());
                    }
                })
                ->indicator(function (array $data): ?string {
                    $count = CheckIn::query()
                        ->when(isset($data['selected_date']) && !empty($data['selected_date']), fn ($query) => $query->whereDate('created_at', $data['selected_date']))
                        ->when(!isset($data['selected_date']) || empty($data['selected_date']), fn ($query) => $query->where('created_at', '>=', Carbon::now()->subMonth()))
                        ->count();

                    if (isset($data['selected_date']) && !empty($data['selected_date'])) {
                        return 'Check-in pada ' . Carbon::parse($data['selected_date'])->toFormattedDateString() . ' (Total: ' . $count . ')';
                    } else {
                        return 'Check-in 1 Bulan Terakhir (Total: ' . $count . ')';
                    }
                }),
        ])
        ->actions([
            Tables\Actions\EditAction::make()->form([
                Forms\Components\TextInput::make('locker_number')->required()->maxLength(10),
                Forms\Components\Toggle::make('uses_locker')->default(true)->hidden(),
            ])->label('Atur Loker'),
        ])
        ->headerActions([
            Action::make('checkInManual')
                ->label('Check-in Manual')
                ->icon('heroicon-o-plus-circle')
                ->form([
                    Forms\Components\Select::make('userId')
                        ->label('Cari Member (Nama atau Email)')
                        ->relationship(name: 'user', titleAttribute: 'name')
                        ->searchable(['name', 'email'])
                        ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->email})")
                        ->required(),
                ])
                ->action(function (array $data) {
                    $user = User::find($data['userId']);
                    if (!$user->activeMembership()->exists()) {
                        Notification::make()->title('Check-in Gagal!')->body('Member ini tidak memiliki membership aktif.')->danger()->send();
                        return;
                    }
                    if ($user->checkIns()->whereDate('created_at', Carbon::today())->count() >= 5) {
                        Notification::make()->title('Check-in Gagal!')->body('Member ini sudah mencapai batas maksimal 5x check-in hari ini.')->warning()->send();
                        return;
                    }
                    CheckIn::create(['user_id' => $user->id]);
                    Notification::make()->title('Check-in Berhasil!')->body($user->name . ' berhasil check-in.')->success()->send();
                })
        ]);
}
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCheckIns::route('/'),
        ];
    }    
}
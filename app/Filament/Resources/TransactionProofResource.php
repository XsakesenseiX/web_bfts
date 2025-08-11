<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionProofResource\Pages;
use App\Filament\Resources\TransactionProofResource\RelationManagers;
use App\Models\TransactionProof;
use App\Exports\TransactionProofExport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Carbon\Carbon;

class TransactionProofResource extends Resource
{
    protected static ?string $model = TransactionProof::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Bukti Transaksi';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?int $navigationSort = 30;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->disabled(), // Admin should not change the user
                Forms\Components\Select::make('membership_id')
                    ->relationship('membership', 'id') // Display membership ID
                    ->required()
                    ->disabled(), // Admin should not change the membership
                Forms\Components\FileUpload::make('proof_path')
                    ->label('Proof of Payment')
                    ->image()
                    ->downloadable()
                    ->openable()
                    ->disabled() // Admin should not change the proof
                    ->getUploadedFileUrlUsing(fn (string $path): string => route('admin.transaction-proofs.show', ['filename' => basename($path)])),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['user', 'membership.membershipPackage'])->where('status', 'approved')->latest())
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email User')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('membership.membershipPackage.name')
                    ->label('Paket Membership')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('membership.membershipPackage.price')
                    ->label('Harga Paket')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Harga tidak tersedia')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('proof_path')
                    ->label('Preview Bukti')
                    ->square()
                    ->size(60)
                    ->url(fn (TransactionProof $record): ?string => $record->proof_path 
                        ? route('admin.transaction-proofs.show', ['filename' => basename($record->proof_path)]) 
                        : null
                    )
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state) => 'Disetujui')
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(50)
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Tanggal Disetujui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\Select::make('month')
                            ->label('Bulan')
                            ->options([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ])
                            ->placeholder('Pilih bulan'),
                        Forms\Components\Select::make('year')
                            ->label('Tahun')
                            ->options(function () {
                                $currentYear = now()->year;
                                $years = [];
                                for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                    $years[$i] = $i;
                                }
                                return $years;
                            })
                            ->placeholder('Pilih tahun'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['month'],
                                fn (Builder $query, $month): Builder => $query->whereMonth('created_at', $month),
                            )
                            ->when(
                                $data['year'],
                                fn (Builder $query, $year): Builder => $query->whereYear('created_at', $year),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['month'] ?? null) {
                            $monthName = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ][$data['month']];
                            $indicators['month'] = 'Bulan: ' . $monthName;
                        }
                        if ($data['year'] ?? null) {
                            $indicators['year'] = 'Tahun: ' . $data['year'];
                        }
                        return $indicators;
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_all')
                    ->label('Export Semua')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $fileName = 'bukti-transaksi-semua-' . now()->format('d-m-Y') . '.xlsx';
                        return Excel::download(new TransactionProofExport(), $fileName);
                    }),
                Tables\Actions\Action::make('export_filtered')
                    ->label('Export Periode')
                    ->icon('heroicon-o-calendar')
                    ->color('primary')
                    ->form([
                        Forms\Components\Select::make('month')
                            ->label('Bulan')
                            ->required()
                            ->options([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ]),
                        Forms\Components\Select::make('year')
                            ->label('Tahun')
                            ->required()
                            ->options(function () {
                                $currentYear = now()->year;
                                $years = [];
                                for ($i = $currentYear; $i >= $currentYear - 5; $i--) {
                                    $years[$i] = $i;
                                }
                                return $years;
                            }),
                    ])
                    ->action(function (array $data) {
                        $monthName = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ][$data['month']];
                        
                        $fileName = 'bukti-transaksi-' . $monthName . '-' . $data['year'] . '.xlsx';
                        return Excel::download(new TransactionProofExport($data['month'], $data['year']), $fileName);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view_proof')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn (TransactionProof $record): ?string => $record->proof_path 
                        ? route('admin.transaction-proofs.show', ['filename' => basename($record->proof_path)]) 
                        : null
                    )
                    ->visible(fn (TransactionProof $record): bool => !empty($record->proof_path))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Remove delete action for approved transactions
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
            'index' => Pages\ListTransactionProofs::route('/'),
            // Remove create and edit pages as this is for viewing approved transactions only
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }
}

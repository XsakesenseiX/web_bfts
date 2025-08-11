<?php

namespace App\Exports;

use App\Models\TransactionProof;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\Builder;

class TransactionProofExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $month;
    protected $year;

    public function __construct($month = null, $year = null)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function query()
    {
        $query = TransactionProof::with(['user', 'membership.membershipPackage'])
            ->where('status', 'approved');

        if ($this->month && $this->year) {
            $query->whereYear('created_at', $this->year)
                  ->whereMonth('created_at', $this->month);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama User',
            'Email User',
            'Paket Membership',
            'Harga Paket',
            'Status',
            'Catatan',
            'Tanggal Transaksi',
            'Tanggal Disetujui',
        ];
    }

    public function map($transactionProof): array
    {
        return [
            $transactionProof->id,
            $transactionProof->user->name ?? 'N/A',
            $transactionProof->user->email ?? 'N/A',
            $transactionProof->membership->membershipPackage->name ?? 'N/A',
            'Rp ' . number_format($transactionProof->membership->membershipPackage->price ?? 0, 0, ',', '.'),
            ucfirst($transactionProof->status),
            $transactionProof->notes ?? '-',
            $transactionProof->created_at->format('d/m/Y H:i:s'),
            $transactionProof->updated_at->format('d/m/Y H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

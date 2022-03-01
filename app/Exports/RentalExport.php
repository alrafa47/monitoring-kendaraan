<?php

namespace App\Exports;

use App\Models\Rental;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class RentalExport implements
    // FromCollection,
    // WithMapping,
    // WithHeadings,
    // ShouldAutoSize,
    FromView,
    ShouldAutoSize,
    WithEvents
{
    public function __construct(int $year)
    {
        $this->year = $year;
    }

    // public function headings(): array
    // {
    //     return [
    //         'Nama',
    //         'Merk Mobil',
    //         'Warna',
    //         'Acc Kabag Kepegawaian',
    //         'Acc Kabag Umum',
    //         'Tanggal Keluar',
    //         'Tanggal Masuk',
    //     ];
    // }

    // public function map($rental): array
    // {
    //     return [
    //         $rental->employee->nama,
    //         $rental->transport->merk,
    //         $rental->transport->warna,
    //         ($rental->acc_divisi_kepegawaian) ? date('d-M-Y', strtotime($rental->acc_divisi_kepegawaian)) : 'belum disetujui',
    //         ($rental->acc_divisi_umum) ? date('d-M-Y', strtotime($rental->acc_divisi_umum)) : 'belum disetujui',
    //         ($rental->tgl_keluar) ? date('d-M-Y', strtotime($rental->tgl_keluar)) : '-',
    //         ($rental->tgl_masuk) ? date('d-M-Y', strtotime($rental->tgl_masuk)) : '-',
    //     ];
    // }

    public function view(): View
    {
        $rentals = Rental::with(['employee', 'transport'])
            ->where(DB::raw('YEAR(tgl_keluar)'), $this->year)
            ->get();
        return view('exports.kelompok', compact('rentals'));
    }

    // public function collection()
    // {
    //     return Rental::with(['employee', 'transport'])
    //         ->where(DB::raw('YEAR(tgl_keluar)'), $this->year)
    //         ->get();
    // }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $to = $event->sheet->getDelegate()->getHighestRowAndColumn();
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                        ],
                    ]
                ]);
                $event->sheet->getStyle('A2:F2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ]
                ]);
                $event->sheet->getStyle(
                    'A3:' . $to['column'] . $to['row']
                )->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                ]);
            },
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            },
        ];
    }
}

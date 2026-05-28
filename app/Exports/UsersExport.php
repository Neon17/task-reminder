<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromArray, WithStyles, WithEvents
{
    protected $users;
    protected $companyName;
    protected $location;

    public function __construct($users, $companyName = 'Your Company Name', $location = 'Your Location')
    {
        $this->users = $users;
        $this->companyName = $companyName;
        $this->location = $location;
    }

    public function array(): array
    {
        $data = [];

        // Add company header rows
        $data[] = [$this->companyName, '', '', '', '', '', ''];
        $data[] = [$this->location, '', '', '', '', '', ''];
        $data[] = ['Users of the System', '', '', '', '', '', ''];
        $data[] = ['Total Users: ' . count($this->users), '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '']; // Empty row

        // Add headers (using fillable fields except password)
        $data[] = [
            'SN',
            'Name',
            'Email',
            'Role',
            'Timezone',
            'Email Verified At',
            'Created At'
        ];

        // Add user data
        $sn = 1;
        foreach ($this->users as $user) {
            $data[] = [
                $sn++,
                $user['name'] ?? $user->name ?? '',
                $user['email'] ?? $user->email ?? '',
                $user['role'] ?? $user->role ?? 'User',
                $user['timezone'] ?? $user->timezone ?? 'UTC',
                $user['email_verified_at'] ?? $user->email_verified_at ?? '',
                $user['created_at'] ?? $user->created_at ?? ''
            ];
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Company name (row 1)
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => 'center']
            ],
            // Location (row 2)
            2 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center']
            ],
            // Title (row 3)
            3 => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => 'center']
            ],
            // Total count (row 4)
            4 => [
                'font' => ['bold' => true, 'size' => 12]
            ],
            // Headers (row 6)
            6 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => 'solid',
                    'color' => ['rgb' => 'E8E8E8']
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin'
                    ]
                ]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A4:G4');
                foreach (range('A', 'G') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }
}
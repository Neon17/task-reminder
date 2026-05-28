<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NotesExport implements FromArray, WithStyles, WithEvents
{
    protected $notes;
    protected $companyName;
    protected $location;

    public function __construct($notes, $companyName = 'Your Company Name', $location = 'Your Location')
    {
        $this->notes = $notes;
        $this->companyName = $companyName;
        $this->location = $location;
    }

    public function array(): array
    {
        $data = [];

        // Add company header rows
        $data[] = [$this->companyName, '', '', '', '', '', ''];
        $data[] = [$this->location, '', '', '', '', '', ''];
        $data[] = ['Reminders of the System', '', '', '', '', '', ''];
        $data[] = ['Total Notes: ' . count($this->notes), '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '']; // Empty row

        // Add headers
        $data[] = [
            'SN',
            'Title',
            'Description',
            'Note Maker',
            'Task',
            'Reason',
            'Assigned Date of Completion (Task)',
            'Created Date',
            'Followers'
        ];

        // Add task data
        $sn = 1;
        foreach ($this->notes as $note) {
            if ($note->task && $note->task->followers){
                $followers = $note->task->followers->pluck('name')->implode(', ') ?? null;
            }
            $data[] = [
                $sn++,
                $note['title'] ?? $note->title ?? '',
                $note['description'] ?? $note->description ?? '',
                $note['creator'] ??isset($note->user) ? $note->user->name : 'N/A',
                $note['task'] ?? isset($note->task) ? $note->task->title : '',
                $note['reason'] ?? $note->notification_start_date ?? '',
                $note['assigned_date'] ?? $note->task->assigned_date ?? '',
                $note['created_date'] ?? $note->created_at ?? '',
                $followers ?? null
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
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                $sheet->mergeCells('A3:H3');
                $sheet->mergeCells('A4:H4');
                foreach (range('A', 'H') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }
}

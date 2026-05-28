<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TasksExport implements FromArray, WithStyles, WithEvents
{
    protected $tasks;
    protected $companyName;
    protected $location;

    public function __construct($tasks, $companyName = 'Your Company Name', $location = 'Your Location')
    {
        $this->tasks = $tasks;
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
        $data[] = ['Total Tasks: ' . count($this->tasks), '', '', '', '', '', ''];
        $data[] = ['', '', '', '', '', '', '']; // Empty row

        // Add headers
        $data[] = [
            'SN',
            'Title',
            'Description',
            'Assigned Date',
            'Notification Start Date',
            'Notification Interval',
            'Created By'
        ];

        // Add task data
        $sn = 1;
        foreach ($this->tasks as $task) {
            $data[] = [
                $sn++,
                $task['title'] ?? $task->title ?? '',
                $task['description'] ?? $task->description ?? '',
                $task['assigned_date'] ?? $task->assigned_date ?? '',
                $task['notification_start_date'] ?? $task->notification_start_date ?? '',
                $task['notification_interval'] ?? $task->notification_interval ?? '',
                isset($task->creator) ? $task->creator->name : (isset($task['creator_name']) ? $task['creator_name'] : 'N/A')
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

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersLogExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userslog;

    public function __construct($userslog)
    {
        $this->userslog = $userslog;
    }

    public function collection()
    {
        return $this->userslog;
    }

    public function headings(): array
    {
        return [
            'IP Address',
            'Log',
            'Request',
            'Response',
        ];
    }

    public function map($userslog): array
    {
        return [
            $userslog->ip,
            $userslog->log,
            $userslog->request,
            $userslog->response
        ];
    }
}
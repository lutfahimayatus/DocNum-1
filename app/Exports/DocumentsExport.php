<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DocumentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $documents;

    public function __construct($documents)
    {
        $this->documents = $documents;
    }

    public function collection()
    {
        return $this->documents;
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'No. Doc',
            'Kode Dokumen',
            'Nama Dokumen',
            'User Log',
            'Tgl Generate',
            'Status'
        ];
    }

    public function map($document): array
    {
        return [
            $document->jenis->category->desc,
            $document->document_number,
            $document->jenis->kode,
            $document->document,
            $document->user->nip . ' - ' . $document->user->name,
            $document->created_at,
            $document->status
        ];
    }
}
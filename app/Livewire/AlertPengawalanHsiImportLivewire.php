<?php

namespace App\Livewire;

use App\Models\AlertPengawalanHsiImport;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AlertPengawalanHsiImportLivewire extends Component
{
    use WithPagination;

    public $page = 10;

    public $headers = [];

    protected $queryString = ['page'];

    public function mount()
    {
        $this->headers = $this->getExcelHeaders();
    }

    public function getExcelHeaders()
    {
        $filePath = storage_path('app/xpro_survey_wo.xlsx');

        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $headerRow = $sheet->rangeToArray('A1:'.$sheet->getHighestColumn().'1', null, true, true, true);

            return array_values(reset($headerRow));
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function render()
    {
        $data = AlertPengawalanHsiImport::paginate(10);

        return view('livewire.alert-pengawalan-hsi-import-livewire', [
            'data' => $data,
            'headers' => $this->headers,
        ]);
    }
}

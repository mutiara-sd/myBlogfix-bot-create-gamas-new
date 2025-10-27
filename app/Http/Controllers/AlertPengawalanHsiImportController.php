<?php

namespace App\Http\Controllers;

class AlertPengawalanHsiImportController extends Controller
{
    public function alertPengawalanHsiImport()
    {
        return view('alert-pengawalan-hsi-import', [
            'title' => 'Alert Pengawalan HSI Import',
        ]);
    }
}

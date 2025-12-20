<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function saleForm()
    {
        $data = [
            'car_price' => 650000,
            'down_percent' => 15,
            'installment' => 48,
        ];

        $pdf = Pdf::loadView('pdf.sale_form', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('sale-form.pdf');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function print(Invoice $record)
    {
        return view('invoices.print', [
            'invoice' => $record,
        ]);
    }
}

<?php

use App\Enums\ServiceStatus;
use App\Http\Controllers\InvoiceController;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Payment;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

Route::get('/invoices/{record}/print', [InvoiceController::class, 'print'])
    ->name('invoices.print')
    ->middleware(['auth']);

Route::get('/test', function () {

    $services = Service::where('type', 'HOST')->get();

    // dd('count: '.$services->count());
    foreach ($services as $service) {
        $contactServices = $service->contactServices()->where('status', ServiceStatus::Active)->count();
        echo 'Name: '.$service->name.'- '.$contactServices.'<br>';
    }
    dd('done');
    $invoices = Invoice::whereNotNull('payment_id')
        ->where('payment_id', '!=', 0)
        ->get();

    // dd('invoices count: '.$invoices->count());
    foreach ($invoices as $invoice) {
        $invoicePayment = InvoicePayment::find($invoice->payment_id);
        if ($invoicePayment) {
            $invoicePayment->invoice_id = $invoice->id;
            $invoicePayment->save();
        }
    }
    // dd('done');
    $payments = Payment::all();
    foreach ($payments as $payment) {
        $invoicePayment = InvoicePayment::find($payment->payment_id);
        $invoicePayment->payment_id = $payment->id;
        $invoicePayment->save();
    }
    dd('done');

    // $invoicePayments = App\Models\InvoicePayment::all();
    // foreach ($invoicePayments as $invoicePayment) {
    //     dd($invoicePayment->payment);
    // }

    // $domains = App\Models\domain::all();
    // foreach ($domains as $domain) {
    //     if (getmxrr($domain->domain, $mx_details)) {
    //         $domain->mx = $mx_details[0];
    //         $domain->save();
    //     }
    // }
});

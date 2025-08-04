<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Invoice;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

class PDFGeneratorService
{
    public function generateInvoicePDFs(Invoice $invoice)
    {
        // Ambil data lengkap invoice
        $invoice = Invoice::with([
            'paket',
            'invoiceMStatus',
            'jamaahs.jamaahMAwalan',
            'transports.transportMJenis',
            'pembayaranDiterimas'
        ])->findOrFail($invoice->id);

        // Render HTML untuk customer
        $customerHtml = View::make('pdf.invoice_customer', compact('invoice'))->render();

        // Render HTML untuk admin
        $adminHtml = View::make('pdf.invoice_admin', compact('invoice'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdfCustomer = new Dompdf($options);
        $dompdfAdmin = new Dompdf($options);

        // Generate PDF Customer
        $dompdfCustomer->loadHtml($customerHtml);
        $dompdfCustomer->setPaper('A4', 'portrait');
        $dompdfCustomer->render();
        $customerPdf = $dompdfCustomer->output();

        // Generate PDF Admin
        $dompdfAdmin->loadHtml($adminHtml);
        $dompdfAdmin->setPaper('A4', 'portrait');
        $dompdfAdmin->render();
        $adminPdf = $dompdfAdmin->output();

        // Simpan file PDF ke storage
        $customerPath = 'invoices/customer/invoice_' . $invoice->kode . '.pdf';
        $adminPath = 'invoices/admin/invoice_' . $invoice->kode . '.pdf';

        Storage::put($customerPath, $customerPdf);
        Storage::put($adminPath, $adminPdf);

        return [
            'customer_pdf_path' => $customerPath,
            'admin_pdf_path' => $adminPath,
        ];
    }
}

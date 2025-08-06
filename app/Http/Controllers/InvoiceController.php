<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InvoiceService;
use App\Services\PDFGeneratorService;
use App\Models\Invoice;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    protected $invoiceService;
    protected $pdfGeneratorService;

    public function __construct(
        InvoiceService $invoiceService,
        PDFGeneratorService $pdfGeneratorService
    ) {
        $this->invoiceService = $invoiceService;
        $this->pdfGeneratorService = $pdfGeneratorService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'paket_nama' => 'required|string',
            'paket_maskapai' => 'required|string',
            'paket_durasi' => 'required|integer',
            'paket_tanggal' => 'required|date',
            'paket_harga' => 'required|numeric',
            'status_id' => 'required|exists:invoice_m_statuses,id',
            'jamaahs' => 'required|array|min:1',
            'jamaahs.*.jamaah_m_awalan_id' => 'required|exists:jamaah_m_awalans,id',
            'jamaahs.*.nama' => 'required|string',
            'transports' => 'required|array',
            'transports.*.transport_m_jenis_id' => 'required|exists:transport_m_jenis,id',
            'transports.*.harga' => 'required|numeric',
            'pembayarans' => 'required|array|min:1',
            'pembayarans.*.jenis' => 'required|string',
            'pembayarans.*.jumlah' => 'required|numeric',
            'pembayarans.*.tanggal' => 'required|date',
        ]);

        $invoice = $this->invoiceService->createInvoice($validated);

        // Generate PDF setelah invoice dibuat
        $pdfPaths = $this->pdfGeneratorService->generateInvoicePDFs($invoice);

        return response()->json([
            'invoice' => $invoice,
            'pdf' => $pdfPaths
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'paket_nama' => 'required|string',
            'paket_maskapai' => 'required|string',
            'paket_durasi' => 'required|integer',
            'paket_tanggal' => 'required|date',
            'paket_harga' => 'required|numeric',
            'status_id' => 'required|exists:invoice_m_statuses,id',
            'jamaahs' => 'required|array|min:1',
            'jamaahs.*.jamaah_m_awalan_id' => 'required|exists:jamaah_m_awalans,id',
            'jamaahs.*.nama' => 'required|string',
            'transports' => 'required|array',
            'transports.*.transport_m_jenis_id' => 'required|exists:transport_m_jenis,id',
            'transports.*.harga' => 'required|numeric',
            'pembayarans' => 'required|array|min:1',
            'pembayarans.*.jenis' => 'required|string',
            'pembayarans.*.jumlah' => 'required|numeric',
            'pembayarans.*.tanggal' => 'required|date',
        ]);

        $invoice = $this->invoiceService->updateInvoice($id, $validated);

        // Generate PDF setelah update
        $pdfPaths = $this->pdfGeneratorService->generateInvoicePDFs($invoice);

        return response()->json([
            'invoice' => $invoice,
            'pdf' => $pdfPaths
        ]);
    }

    public function show($id)
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        return response()->json($invoice);
    }

    public function destroy($id)
    {
        $deleted = $this->invoiceService->deleteInvoice($id);
        return response()->json($deleted);
    }

    public function index()
    {
        $invoices = $this->invoiceService->getAllInvoices();
        return response()->json($invoices);
    }

    public function downloadPdf(Request $request, $id)
    {
        $type = $request->query('type', 'customer'); // default ke customer
        $invoice = $this->invoiceService->getInvoiceById($id);
        $pdfPaths = $this->pdfGeneratorService->generateInvoicePDFs($invoice);

        if ($type === 'admin') {
            $pdfPath = $pdfPaths['admin_pdf_path'] ?? null;
        } else {
            $pdfPath = $pdfPaths['customer_pdf_path'] ?? null;
        }

        if (!$pdfPath || !Storage::exists($pdfPath)) {
            return response()->json(['message' => 'PDF not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->download(storage_path('app/' . $pdfPath));
    }
}

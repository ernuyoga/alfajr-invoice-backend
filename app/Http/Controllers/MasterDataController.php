<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InvoiceMStatusService;
use App\Services\JamaahMAwalanService;
use App\Services\TransportMJenisService;
use App\Models\InvoiceMStatus;
use App\Models\JamaahMAwalan;
use App\Models\TransportMJenis;

class MasterDataController extends Controller
{
    protected $statusService;
    protected $awalanService;
    protected $transportJenisService;

    public function __construct(
        InvoiceMStatusService $statusService,
        JamaahMAwalanService $awalanService,
        TransportMJenisService $transportJenisService
    ) {
        $this->statusService = $statusService;
        $this->awalanService = $awalanService;
        $this->transportJenisService = $transportJenisService;
    }

    // Status Invoice

    public function getAllStatus()
    {
        return response()->json($this->statusService->getAllStatus());
    }

    public function createStatus(Request $request)
    {
        $request->validate(['nama' => 'required|string']);
        $status = $this->statusService->createStatus($request->nama);
        return response()->json($status, 201);
    }

    public function updateStatus(Request $request, InvoiceMStatus $status)
    {
        $request->validate(['nama' => 'required|string']);
        $status = $this->statusService->updateStatus($status, $request->nama);
        return response()->json($status);
    }

    public function deleteStatus(InvoiceMStatus $status)
    {
        $deleted = $this->statusService->deleteStatus($status);
        return response()->json($deleted);
    }

    // Awalan Jamaah

    public function getAllAwalan()
    {
        return response()->json($this->awalanService->getAllAwalan());
    }

    public function createAwalan(Request $request)
    {
        $request->validate(['nama' => 'required|string']);
        $awalan = $this->awalanService->createAwalan($request->nama);
        return response()->json($awalan, 201);
    }

    public function updateAwalan(Request $request, JamaahMAwalan $awalan)
    {
        $request->validate(['nama' => 'required|string']);
        $awalan = $this->awalanService->updateAwalan($awalan, $request->nama);
        return response()->json($awalan);
    }

    public function deleteAwalan(JamaahMAwalan $awalan)
    {
        $deleted = $this->awalanService->deleteAwalan($awalan);
        return response()->json($deleted);
    }

    // Jenis Transport

    public function getAllTransportJenis()
    {
        return response()->json($this->transportJenisService->getAllJenis());
    }

    public function createTransportJenis(Request $request)
    {
        $request->validate(['nama' => 'required|string']);
        $jenis = $this->transportJenisService->createJenis($request->nama);
        return response()->json($jenis, 201);
    }

    public function updateTransportJenis(Request $request, TransportMJenis $jenis)
    {
        $request->validate(['nama' => 'required|string']);
        $jenis = $this->transportJenisService->updateJenis($jenis, $request->nama);
        return response()->json($jenis);
    }

    public function deleteTransportJenis(TransportMJenis $jenis)
    {
        $deleted = $this->transportJenisService->deleteJenis($jenis);
        return response()->json($deleted);
    }
}

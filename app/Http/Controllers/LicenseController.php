<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\LicenseStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LicenseController extends Controller {
    public function getData(Request $request, int $contract): JsonResponse {
        $_contract = Contract::findOrFail($contract);
        $status = intval($request->status);
        $query = $_contract->licenses()
            ->get()
            ->filter(function ($license) use ($status) {
                if ($status == 0)
                    return true;
                if ($license->status == $status)
                    return true;
                return false;
            });

        return DataTables::of($query)
            ->editColumn('status', fn($license) => LicenseStatus::getName($license->status))
            ->addColumn('action', function ($license) {
                $fixRoute = route('dashboard');
                $items = [];
                if ($license->status == LicenseStatus::USING->value || $license->status == LicenseStatus::BROKEN->value)
                    $items[] = ['type' => 'item', 'link' => $fixRoute, 'icon' => 'fas fa-tools', 'title' => 'Исправить'];
                return createDropdown('Действия', $items);
            })
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(int $contract) {
        $_contract = Contract::findOrFail($contract);
        $heading = sprintf("Лицензии контракта № %s клиента &laquo;%s&raquo;", $_contract->number, $_contract->client->getTitle());

        return view('licenses.index', [
            'contract' => $contract,
            'heading' => $heading,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
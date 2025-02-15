<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorResponse;
use App\Http\Requests\EmployeRequest;
use App\Services\EmployeService;
use Exception;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    protected $employeService;
    public function __construct(EmployeService $employeService)
    {
        $this->employeService = $employeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $employes = $this->employeService->list();
            return response()->json($employes);
        } catch (Exception $e) {
            return ErrorResponse::send($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeRequest $request)
    {
        try {
            $data = $request->validated();
            $employee = $this->employeService->create($data);

            return response()->json($employee, 201);
        } catch (Exception $e) {
            return ErrorResponse::send($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

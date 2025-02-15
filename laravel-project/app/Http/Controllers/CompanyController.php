<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorResponse;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    protected $companyService;
    public function __construct(CompanyService $companyService){
        $this->companyService=$companyService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        try{
            $companies = $this->companyService->list();
            return response()->json($companies);
        }catch(Exception $e){
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
    public function store(CompanyRequest $request)
    {
        try{
            $data=$request->validated();
            return new CompanyResource($this->companyService->create($data));
        }catch(Exception $e){
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

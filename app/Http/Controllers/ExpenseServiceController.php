<?php

namespace App\Http\Controllers;

use App\Models\Expense_service;
use App\Http\Requests\StoreExpense_serviceRequest;
use App\Http\Requests\UpdateExpense_serviceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ExpenseServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpense_serviceRequest $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense_service $expense_service): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense_service $expense_service): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpense_serviceRequest $request, Expense_service $expense_service): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense_service $expense_service): RedirectResponse
    {
        //
    }
}

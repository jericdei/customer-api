<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Filters, sorts, search

        if ($request->has('page')) {
            return $query->paginate(
                perPage: $request->integer('per_page', 10),
                page: $request->integer('page', 1)
            );
        }

        return response()->json([
            'customers' => $query->get()
        ]);
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(UpsertCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return response()->json([
            'message' => 'Customer has been created.',
            'customer' => $customer
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(UpsertCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return response()->json([
            'message' => 'Customer has been updated.',
            'customer' => $customer->fresh(),
        ]);
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'message' => 'Customer has been deleted.',
        ]);
    }
}

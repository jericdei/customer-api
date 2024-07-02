<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListCustomerRequest;
use App\Http\Requests\UpsertCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(ListCustomerRequest $request)
    {
        $query = Customer::query();

        if ($request->has('q')) {
            $query = Customer::search($request->input('q'));
        }

        if ($request->has('sort')) {
            $query->orderBy($request->input('sort.field'), $request->input('sort.order', 'asc'));
        }

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

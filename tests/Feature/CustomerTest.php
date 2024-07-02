<?php

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can list all customers', function () {
    Customer::factory(5)->create();

    $this->getJson(route('customers.index'))->assertOk();
});

it('can list all paginated customers', function () {
    Customer::factory(5)->create();

    $response = $this->getJson(route('customers.index', [
        'page' => 1
    ]));

    $response->assertOk();
    $response->assertJson(['current_page' => 1]);
});

it('can search customers', function () {
    Customer::factory(4)->create();
    Customer::factory()->create([
        'first_name' => 'LeBron'
    ]);

    $response = $this->getJson(route('customers.index', [
        'q' => 'bron'
    ]));

    $response->assertOk();

    expect(count($response->json('customers')))->toBeGreaterThanOrEqual(1);
});

it('can sort customers by field', function () {
    Customer::factory()->createMany([
        ['last_name' => 'Zygote'],
        ['last_name' => 'Aamen']
    ]);

    $response = $this->getJson(route('customers.index', [
        'sort' => [
            'field' => 'last_name',
            'order' => 'desc'
        ]
    ]));

    $response->assertOk();

    expect($response->json('customers')[0])->last_name->toBe('Zygote')
        ->and($response->json('customers')[1])->last_name->toBe('Aamen');
});

it('can store a customer', function () {
    $response = $this->postJson(route('customers.store'), [
        'first_name' => 'LeBron',
        'last_name' => 'James',
        'email' => 'lebronjames@example.com',
        'contact_number' => '09123456789'
    ]);

    $response->assertOk();

    expect(Customer::first())->full_name->toBe('LeBron James');
});

it('can update a customer', function () {
    $customer = Customer::factory()->create([
        'first_name' => 'LeBron',
        'last_name' => 'James',
        'email' => 'lebronjames@example.com',
        'contact_number' => '09123456789'
    ]);

    $response = $this->patchJson(route('customers.update', $customer->id), [
        'first_name' => 'Bronny'
    ]);

    $response->assertOk();

    expect($customer->fresh())->full_name->toBe('Bronny James');
});

it('can delete a customer', function () {
    $customer = Customer::factory()->create();

    $response = $this->deleteJson(route('customers.destroy', $customer->id));

    $response->assertOk();

    expect(Customer::all())->toBeEmpty();
});

<?php

namespace App\Http\Controllers\Apps;

use App\Services\JabodetabekValidatorService;
use Inertia\Inertia;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    private JabodetabekValidatorService $jabodetabekValidator;

    public function __construct(JabodetabekValidatorService $jabodetabekValidator)
    {
        $this->jabodetabekValidator = $jabodetabekValidator;
    }

    public function index()
    {
        //get customers
        $customers = Customer::when(request()->search, function ($customers) {
            $customers = $customers->where('name', 'like', '%' . request()->search . '%');
        })->latest()->paginate(5);

        //return inertia
        return Inertia::render('Dashboard/Customers/Index', [
            'customers' => $customers,
        ]);
    }


    public function create()
    {
        return Inertia::render('Dashboard/Customers/Create');
    }


    public function store(Request $request)
    {
        /**
         * validate
         */
        $request->validate([
            'name' => 'required',
            'no_telp' => 'required|unique:customers',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);

        // Validate that the customer is in Jabodetabek region
        if (!$this->jabodetabekValidator->isJabodetabek($request->city, $request->province, $request->address)) {
            return redirect()->back()
                ->withErrors(['location' => 'Maaf, kami hanya melayani pembelian untuk wilayah Jabodetabek (Jakarta, Bogor, Depok, Tangerang, Bekasi).'])
                ->withInput();
        }

        //create customer
        Customer::create([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
        ]);

        //redirect
        return to_route('customers.index');
    }


    public function edit(Customer $customer)
    {
        return Inertia::render('Dashboard/Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        /**
         * validate
         */
        $request->validate([
            'name' => 'required',
            'no_telp' => 'required|unique:customers,no_telp,' . $customer->id,
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
        ]);

        // Validate that the customer is in Jabodetabek region
        if (!$this->jabodetabekValidator->isJabodetabek($request->city, $request->province, $request->address)) {
            return redirect()->back()
                ->withErrors(['location' => 'Maaf, kami hanya melayani pembelian untuk wilayah Jabodetabek (Jakarta, Bogor, Depok, Tangerang, Bekasi).'])
                ->withInput();
        }

        //update customer
        $customer->update([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
        ]);

        //redirect
        return to_route('customers.index');
    }

    public function destroy($id)
    {
        //find customer by ID
        $customer = Customer::findOrFail($id);

        //delete customer
        $customer->delete();

        //redirect
        return back();
    }
}

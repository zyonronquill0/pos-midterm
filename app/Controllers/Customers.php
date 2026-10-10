<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    // Display customer accounts
    public function index()
    {
        $data = [
            'title'     => 'Customer Accounts',
            'customers' => $this->customerModel->findAll(),
        ];

        return view('customers/index', $data);
    }

    // Show form to add new customer
    public function new()
    {
        helper('form');
        return view('customers/new', ['title' => 'New Customer']);
    }

    // Process submission of new customer
    public function create()
    {
        helper('form');

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return view('customers/new', [
                'title'      => 'New Customer',
                'validation' => $this->validator,
            ]);
        }

        $this->customerModel->save([
            'full_name'  => $this->request->getPost('full_name'),
            'email'      => $this->request->getPost('email'),
            'phone'      => $this->request->getPost('phone'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('customers'))->with('message', 'Customer created successfully.');
    }

    // Show form to edit existing customer
    public function edit($id)
    {
        helper('form');
        $customer = $this->customerModel->find($id);

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound("Customer #{$id} not found.");
        }

        return view('customers/edit', [
            'title'    => 'Edit Customer',
            'customer' => $customer,
        ]);
    }

    // Process update of customer
    public function update($id)
    {
        helper('form');
        $customer = $this->customerModel->find($id);

        if (! $customer) {
            throw PageNotFoundException::forPageNotFound("Customer #{$id} not found.");
        }

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return view('customers/edit', [
                'title'      => 'Edit Customer',
                'customer'   => $customer,
                'validation' => $this->validator,
            ]);
        }

        $this->customerModel->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
        ]);

        return redirect()->to(base_url('customers'))->with('message', 'Customer updated successfully.');
    }
}
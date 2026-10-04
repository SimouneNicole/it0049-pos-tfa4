<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index(): string
    {
        $customerModel = new CustomerModel();

        $data = [
            'title'     => 'Customer Accounts',
            'customers' => $customerModel->findAll(),
        ];

        return view('customers/index', $data);
    }

    public function new(): string
    {
        return view('customers/new', ['title' => 'Add New Customer']);
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $customerModel = new CustomerModel();
        $customerModel->insert([
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
            'created_at'=> date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/customers')->with('success', 'Customer account added successfully.');
    }

    public function edit(int $id): string
    {
        $customerModel = new CustomerModel();
        $customer = $customerModel->find($id);

        if ($customer === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customers/edit', [
            'title'    => 'Edit Customer',
            'customer' => $customer,
        ]);
    }

    public function update(int $id)
    {
        $customerModel = new CustomerModel();

        if ($customerModel->find($id) === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'email'     => 'required|valid_email|max_length[100]',
            'phone'     => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $customerModel->update($id, [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
        ]);

        return redirect()->to('/customers')->with('success', 'Customer account updated successfully.');
    }
}

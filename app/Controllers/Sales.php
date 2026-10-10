<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Sales extends BaseController
{
    protected $saleModel;
    protected $productModel;
    protected $customerModel;

    public function __construct()
    {
        $this->saleModel     = new SaleModel();
        $this->productModel   = new ProductModel();
        $this->customerModel  = new CustomerModel();
    }

    // List sales history
    public function index()
    {
        $data = [
            'title' => 'Sales History',
            'sales' => $this->saleModel->getSalesHistory(),
        ];

        return view('sales/index', $data);
    }

    // Show record sale checkout form
    public function new()
    {
        helper('form');

        $data = [
            'title'     => 'Record a Sale',
            'products'  => $this->productModel->where('stock_quantity >', 0)->findAll(),
            'customers' => $this->customerModel->orderBy('full_name', 'ASC')->findAll(),
        ];

        return view('sales/new', $data);
    }

    // Process sale transaction with stock deduction
    public function create()
    {
        helper('form');

        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'quantity'   => 'required|is_natural_no_zero',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please select a valid product and quantity.');
        }

        $productId   = (int) $this->request->getPost('product_id');
        $quantity    = (int) $this->request->getPost('quantity');
        $customerId  = $this->request->getPost('customer_id');
        $customerId  = ! empty($customerId) ? (int) $customerId : null;
        $soldBy      = (int) session()->get('userId');

        // Verify product existence and stock
        $product = $this->productModel->find($productId);

        if (! $product) {
            return redirect()->back()->withInput()->with('error', 'Selected product was not found.');
        }

        if ($quantity > (int) $product['stock_quantity']) {
            return redirect()->back()->withInput()->with(
                'error',
                "Insufficient stock! Requested {$quantity} units, but only {$product['stock_quantity']} units of '{$product['name']}' are available."
            );
        }

        $totalPrice = (float) $product['price'] * $quantity;
        $newStock   = (int) $product['stock_quantity'] - $quantity;

        // Perform sale insertion and inventory reduction inside a database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        $this->saleModel->save([
            'product_id'  => $productId,
            'customer_id' => $customerId,
            'sold_by'     => $soldBy,
            'quantity'    => $quantity,
            'total_price' => $totalPrice,
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        $this->productModel->update($productId, [
            'stock_quantity' => $newStock,
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Transaction failed. Please try again.');
        }

        return redirect()->to(base_url('sales'))->with(
            'message',
            "Sale recorded! Sold {$quantity}x {$product['name']} for ₱" . number_format($totalPrice, 2)
        );
    }
}
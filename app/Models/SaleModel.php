<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['product_id', 'customer_id', 'sold_by', 'quantity', 'total_price', 'created_at'];
    protected $useTimestamps    = false;

    // Relational query joining products, customers, and staff users
    public function getSalesHistory()
    {
        return $this->select('sales.*, products.name AS product_name, products.price AS unit_price, customers.full_name AS customer_name, users.full_name AS staff_name')
                    ->join('products', 'products.id = sales.product_id', 'left')
                    ->join('customers', 'customers.id = sales.customer_id', 'left')
                    ->join('users', 'users.id = sales.sold_by', 'left')
                    ->orderBy('sales.created_at', 'DESC')
                    ->findAll();
    }
}
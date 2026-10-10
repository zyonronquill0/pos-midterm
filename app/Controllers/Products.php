<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Products extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    // List all products
    public function index()
    {
        $data = [
            'title'    => 'Product Management',
            'products' => $this->productModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('products/index', $data);
    }

    // Show add product form
    public function new()
    {
        helper('form');
        return view('products/new', ['title' => 'Add New Product']);
    }

    // Handle new product submission
    public function create()
    {
        helper('form');

        $rules = [
            'name'           => 'required|min_length[2]|max_length[100]',
            'price'          => 'required|decimal|greater_than[0]',
            'stock_quantity' => 'required|is_natural',
            'image'          => 'permit_empty|uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
        ];

        if (! $this->validate($rules)) {
            return view('products/new', [
                'title'      => 'Add New Product',
                'validation' => $this->validator,
            ]);
        }

        $imageName = null;
        $imageFile = $this->request->getFile('image');

        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $uploadPath = FCPATH . 'uploads/products';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $imageFile->move($uploadPath, $imageName);

            // Resize product image for display
            try {
                Services::image()
                    ->withFile($uploadPath . '/' . $imageName)
                    ->fit(300, 300, 'center')
                    ->save($uploadPath . '/' . $imageName);
            } catch (\Exception $e) {
                // Keep original if resize fails
            }
        }

        $this->productModel->save([
            'name'           => $this->request->getPost('name'),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image'          => $imageName,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('products'))->with('message', 'Product added successfully.');
    }

    // Show edit product form
    public function edit($id)
    {
        helper('form');
        $product = $this->productModel->find($id);

        if (! $product) {
            throw PageNotFoundException::forPageNotFound("Product #{$id} not found.");
        }

        return view('products/edit', [
            'title'   => 'Edit Product',
            'product' => $product,
        ]);
    }

    // Handle product update
    public function update($id)
    {
        helper('form');
        $product = $this->productModel->find($id);

        if (! $product) {
            throw PageNotFoundException::forPageNotFound("Product #{$id} not found.");
        }

        $rules = [
            'name'           => 'required|min_length[2]|max_length[100]',
            'price'          => 'required|decimal|greater_than[0]',
            'stock_quantity' => 'required|is_natural',
            'image'          => 'permit_empty|uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
        ];

        if (! $this->validate($rules)) {
            return view('products/edit', [
                'title'      => 'Edit Product',
                'product'    => $product,
                'validation' => $this->validator,
            ]);
        }

        $updateData = [
            'name'           => $this->request->getPost('name'),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ];

        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $uploadPath = FCPATH . 'uploads/products';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $imageFile->move($uploadPath, $imageName);

            try {
                Services::image()
                    ->withFile($uploadPath . '/' . $imageName)
                    ->fit(300, 300, 'center')
                    ->save($uploadPath . '/' . $imageName);
            } catch (\Exception $e) {
                // Keep original if resize fails
            }

            // Delete old image file if exists
            if (! empty($product['image']) && file_exists($uploadPath . '/' . $product['image'])) {
                unlink($uploadPath . '/' . $product['image']);
            }

            $updateData['image'] = $imageName;
        }

        $this->productModel->update($id, $updateData);

        return redirect()->to(base_url('products'))->with('message', 'Product updated successfully.');
    }

    // Delete product
    public function delete($id)
    {
        $product = $this->productModel->find($id);

        if ($product) {
            if (! empty($product['image'])) {
                $filePath = FCPATH . 'uploads/products/' . $product['image'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $this->productModel->delete($id);
        }

        return redirect()->to(base_url('products'))->with('message', 'Product deleted successfully.');
    }
}
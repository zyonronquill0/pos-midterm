<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Display user accounts list
    public function index()
    {
        $data = [
            'title' => 'User Accounts',
            'users' => $this->userModel->findAll(),
        ];

        return view('users/index', $data);
    }

    // Show form to create new user
    public function new()
    {
        helper('form');
        return view('users/new', ['title' => 'New User Account']);
    }

    // Process new user creation
    public function create()
    {
        helper('form');

        $rules = [
            'username'  => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|min_length[3]|max_length[100]',
            'password'  => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return view('users/new', [
                'title'      => 'New User Account',
                'validation' => $this->validator,
            ]);
        }

        $this->userModel->save([
            'username'   => $this->request->getPost('username'),
            'full_name'  => $this->request->getPost('full_name'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'avatar'     => null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('users'))->with('message', 'User account created successfully.');
    }

    // Show form to edit user and upload avatar
    public function edit($id)
    {
        helper('form');
        $user = $this->userModel->find($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound("User #{$id} not found.");
        }

        return view('users/edit', [
            'title' => 'Edit User Account',
            'user'  => $user,
        ]);
    }

    // Process user update and image upload
    public function update($id)
    {
        helper('form');
        $user = $this->userModel->find($id);

        if (! $user) {
            throw PageNotFoundException::forPageNotFound("User #{$id} not found.");
        }

        $rules = [
            'username'  => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|min_length[3]|max_length[100]',
            'password'  => 'permit_empty|min_length[6]',
            'avatar'    => 'permit_empty|uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]',
        ];

        if (! $this->validate($rules)) {
            return view('users/edit', [
                'title'      => 'Edit User Account',
                'user'       => $user,
                'validation' => $this->validator,
            ]);
        }

        $updateData = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
        ];

        // Hash new password if one was supplied
        $newPassword = $this->request->getPost('password');
        if (! empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Process file upload if provided
        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile && $avatarFile->isValid() && ! $avatarFile->hasMoved()) {
            $newName = $avatarFile->getRandomName();
            $uploadPath = FCPATH . 'uploads/avatars';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $avatarFile->move($uploadPath, $newName);

            // Create square thumbnail using CodeIgniter Image Service
            try {
                Services::image()
                    ->withFile($uploadPath . '/' . $newName)
                    ->fit(120, 120, 'center')
                    ->save($uploadPath . '/' . $newName);
            } catch (\Exception $e) {
                // Keep original file if image processing fails
            }

            $updateData['avatar'] = $newName;
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to(base_url('users'))->with('message', 'User account updated successfully.');
    }
}
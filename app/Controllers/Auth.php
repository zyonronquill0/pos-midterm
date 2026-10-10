<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('customers'));
        }

        helper('form');
        return view('auth/login', ['title' => 'Sign In']);
    }

    public function attemptLogin()
    {
        helper('form');

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return view('auth/login', [
                'title'      => 'Sign In',
                'validation' => $this->validator,
            ]);
        }

        $userModel = new UserModel();
        $username  = trim((string) $this->request->getPost('username'));
        $password  = (string) $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
        }

        session()->set([
            'userId'     => $user['id'],
            'username'   => $user['username'],
            'fullName'   => $user['full_name'],
            'avatar'     => $user['avatar'] ?? null,
            'isLoggedIn' => true,
        ]);

        return redirect()->to(base_url('customers'))->with('message', 'Welcome back, ' . $user['full_name'] . '!');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'))->with('message', 'You have been successfully logged out.');
    }
}
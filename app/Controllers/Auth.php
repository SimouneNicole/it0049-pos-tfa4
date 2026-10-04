<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/customers');
        }

        return view('auth/login', ['title' => 'Staff Login']);
    }

    public function attempt()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required|min_length[8]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $username = (string) $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid username or password.');
        }

        session()->regenerate();
        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'username'   => $user['username'],
        ]);

        return redirect()->to('/customers')->with('success', 'Welcome, ' . $user['username'] . '.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}

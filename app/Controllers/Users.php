<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index(): string
    {
        $userModel = new UserModel();

        $data = [
            'title' => 'User Accounts',
            'users' => $userModel->findAll(),
        ];

        return view('users/index', $data);
    }

    public function new(): string
    {
        return view('users/new', ['title' => 'Add New User']);
    }

    public function create()
    {
        $rules = [
            'username'         => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'full_name'        => 'required|min_length[3]|max_length[100]',
            'password'         => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $userModel = new UserModel();
        $userModel->insert([
            'username'   => $this->request->getPost('username'),
            'password'   => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name'  => $this->request->getPost('full_name'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users')->with('success', 'User account added successfully.');
    }

    public function edit(int $id): string
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('users/edit', [
            'title' => 'Edit User',
            'user'  => $user,
        ]);
    }

    public function update(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = [
            'username'  => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|min_length[3]|max_length[100]',
        ];

        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            $rules['password'] = 'required|min_length[8]|max_length[255]';
            $rules['password_confirm'] = 'required|matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $avatar = $this->request->getFile('avatar');
        $newName = $user['avatar'] ?? null;

        if ($avatar !== null && $avatar->getError() !== UPLOAD_ERR_NO_FILE) {
            $fileRules = [
                'avatar' => [
                    'rules' => [
                        'uploaded[avatar]',
                        'max_size[avatar,2048]',
                        'mime_in[avatar,image/jpeg,image/png]',
                    ],
                    'errors' => [
                        'uploaded' => 'Please choose an image to upload.',
                        'max_size' => 'The profile picture must not be larger than 2 MB.',
                        'mime_in'  => 'The profile picture must be a JPG or PNG file.',
                    ],
                ],
            ];

            if (! $this->validateData([], $fileRules)) {
                return redirect()->back()->withInput();
            }

            $newName = $avatar->getRandomName();
            $uploadPath = FCPATH . 'uploads';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $avatar->move($uploadPath, $newName);

            $image = service('image');
            $image->withFile($uploadPath . DIRECTORY_SEPARATOR . $newName)
                ->fit(300, 300, 'center')
                ->save($uploadPath . DIRECTORY_SEPARATOR . $newName);
        }

        $userData = [
            'username'  => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'avatar'    => $newName,
        ];

        if ($password !== '') {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $userData);

        if ((int) session()->get('user_id') === $id) {
            session()->set('username', $userData['username']);
        }

        return redirect()->to('/users')->with('success', 'User account updated successfully.');
    }
}

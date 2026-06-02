<?php
namespace App\Controller;

use Authentication\PasswordHasher\DefaultPasswordHasher;

class UsersController extends AppController
{
    public function login()
    {
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            return $this->redirect(['controller' => 'Bills', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $this->Flash->error('Invalid login');
        }
    }

    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $hasher = new DefaultPasswordHasher();
            $data['password'] = $hasher->hash($data['password']);

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success('User created');
            }
        }

        $this->set(compact('user'));
    }
}
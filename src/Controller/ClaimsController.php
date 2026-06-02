<?php
namespace App\Controller;

class ClaimsController extends AppController
{
    public function index()
    {
        $claims = $this->fetchTable('Bills')
            ->find()
            ->where(['insurance_amount >' => 0]);

        $this->set(compact('claims'));
    }

    public function approve($id)
    {
        $bill = $this->fetchTable('Bills')->get($id);
        $bill->insurance_status = 'approved';

        $this->fetchTable('Bills')->save($bill);
        return $this->redirect(['action' => 'index']);
    }
}
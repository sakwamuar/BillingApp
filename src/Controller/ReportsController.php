<?php
namespace App\Controller;

class ReportsController extends AppController
{
    public function index()
    {
        $totalBills = $this->fetchTable('Bills')->find()->count();

        $revenue = $this->fetchTable('Bills')
            ->find()
            ->select(['sum' => 'SUM(total)'])
            ->first()
            ->sum;

        $claims = $this->fetchTable('Bills')
            ->find()
            ->where(['insurance_status' => 'pending'])
            ->count();

        $this->set(compact('totalBills', 'revenue', 'claims'));
    }
}
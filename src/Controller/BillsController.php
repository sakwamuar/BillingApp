<?php
namespace App\Controller;

use Dompdf\Dompdf;

class BillsController extends AppController
{
    public function index()
    {
        $bills = $this->Bills->find()->contain(['Patients']);
        $this->set(compact('bills'));
    }

    public function add()
    {
        $bill = $this->Bills->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $data['total'] = ($data['subtotal'] - $data['discount'])
                - $data['insurance_amount']
                - $data['cash_amount'];

            $data['insurance_status'] = 'pending';
            $data['claim_reference'] = uniqid('CLM-');

            $bill = $this->Bills->patchEntity($bill, $data);

            if ($this->Bills->save($bill)) {
                return $this->redirect(['action' => 'index']);
            }
        }

        $patients = $this->Bills->Patients->find('list');
        $this->set(compact('bill', 'patients'));
    }

    public function invoice($id)
    {
        $bill = $this->Bills->get($id, ['contain' => ['Patients']]);

        $html = "<h1>Invoice</h1>";
        $html .= "<p>Patient: {$bill->patient->name}</p>";
        $html .= "<p>Total: {$bill->total}</p>";

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return $this->response
            ->withType('application/pdf')
            ->withStringBody($dompdf->output());
    }
}
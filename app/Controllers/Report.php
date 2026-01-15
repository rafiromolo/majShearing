<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\M_curl;

class Report extends BaseController
{
    protected $SAP_PARAMS = [];

    public function index()
    {
        return view('main/main');
    }

    public function material()
    {
        $M_curl = new M_curl();
        
        $this->SAP_PARAMS['function'] = 'Z_PUD';
        $this->SAP_PARAMS['params'] = [
            'RPT' => 'SHEAR'
        ];

        $sap = $M_curl->execute("POST", $this->SAP_PARAMS);

        if (!$sap['success']) {
            log_message('error', json_encode($sap));

            return $this->response->setJSON([
                'success' => false,
                'error_code' => 'SAP_TIMEOUT',
                'message' => 'Sistem SAP sedang tidak dapat diakses. Silakan coba lagi.'
            ])->setStatusCode(500);
        }

        $data = json_decode(json_encode($sap), true);
        // $responseData = $data['data']['ZDT_MTRL2'] ?? [];
        $responseData = $data;

        return $this->response->setJSON($responseData);
    }

    public function shearing()
    {
        $M_curl = new M_curl();

        // Ambil input dari frontend
        $request = $this->request->getJSON(true);
        $material = $request['material'] ?? null;

        if (empty($material)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Material kosong'
            ]);
        }

        $today = date('Ymd');

        $this->SAP_PARAMS['function'] = 'Z_PUD';
        $this->SAP_PARAMS['params'] = [
            'RPT' => 'SHEAR',
            'P_MATNR' => $material,
        ];

        $sap = $M_curl->execute("POST", $this->SAP_PARAMS);

        if ($sap['data']['MATNR'] == "") {
            log_message('error', json_encode($sap));

            return $this->response->setJSON([
                'data' => [
                    'success' => false,
                    'error_code' => 'BOM_MISSING',
                    'message' => 'Material shearing tidak ditemukan. Coba cek kembali job number atau material number.'
                ]
            ])->setStatusCode(404);
        }

        $data = json_decode(json_encode($sap), true);

        // $responseData = $data['data'] ?? [];

        return $this->response->setJSON([
            'data' => $data,
            'MATNR' => $data['data']['MATNR'] ?? null,
            'MENGE' => $data['data']['MENGE'] ?? null
        ]);
    }

    public function spec_shearing()
    {
        $M_curl = new M_curl();
        
        $this->SAP_PARAMS['function'] = 'Z_PUD';
        $this->SAP_PARAMS['params'] = [
            'RPT' => 'SHEAR'
        ];

        $sap = $M_curl->execute("POST", $this->SAP_PARAMS);
        $data = json_decode(json_encode($sap), true);
        $responseData = $data['data']['ZDT_SHEAR2'] ?? [];

        return $this->response->setJSON($responseData);
    }

    public function create_order()
    {
        $M_curl = new M_curl();

        $request = $this->request->getJSON(true);
        $shearing = $request['shearing'] ?? null;
        $quantity = $request['quantity'] ?? null;

        if (empty($shearing)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Shearing kosong'
            ]);
        }

        // $responseData = [
        //     'shearing' => $shearing,
        //     'quantity' => $quantity
        // ];

        $this->SAP_PARAMS['function'] = 'Z_PUD';
        $this->SAP_PARAMS['params'] = [
            'RPT' => 'SHEAR',
            'P_MATNR' => $shearing,
            'ZQTYSHR_INP' => $quantity,
            'ZCR_ORD_SHR' => 'X'
        ];

        $sap = $M_curl->execute("POST", $this->SAP_PARAMS);
        $data = json_decode(json_encode($sap), true);
        $responseData = $data['data']['ZSHEARING_RFC'] ?? [];
        // $responseData = $data;

        return $this->response->setJSON($responseData);
    }

    public function print()
    {
        $data = [
            'tanggal'       => $this->request->getGet('tanggal'),
            'shift'         => $this->request->getGet('shift'),
            'mesin'         => $this->request->getGet('mesin'),
            'operator'      => $this->request->getGet('operator'),

            'jobNumber'     => $this->request->getGet('jobNumber'),
            'material'      => $this->request->getGet('material'),
            'mspec'         => $this->request->getGet('mspec'),
            'mThickness'    => $this->request->getGet('mThickness'),
            'mWidth'        => $this->request->getGet('mWidth'),
            'mLength'       => $this->request->getGet('mLength'),
            'sThickness'    => $this->request->getGet('sThickness'),
            'sWidth'        => $this->request->getGet('sWidth'),
            'sLength'       => $this->request->getGet('sLength'),
            'customer'      => $this->request->getGet('customer'),
            'sheet'         => $this->request->getGet('sheet'),
            'bq'            => $this->request->getGet('bq'),
            'pcs'           => $this->request->getGet('pcs'),

            'shear_material' => $this->request->getGet('shear_material'),
            'sspec'          => $this->request->getGet('sspec'),
        ];

        return view('main/print', $data);
    }
}

?>
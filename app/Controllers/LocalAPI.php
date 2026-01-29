<?php

namespace App\Controllers;

class LocalAPI extends BaseController
{
    public function index()
    {
        return $this->response
            ->setStatusCode(200)
            ->setJSON([
                'status'  => true,
                'message' => 'API OK',
                'data'    => [
                    [
                        'id'   => 1,
                        'name' => 'Steve'
                    ],
                    [
                        'id'   => 2,
                        'name' => 'Harrington'
                    ]
                ]
            ]);
    }
}

?>
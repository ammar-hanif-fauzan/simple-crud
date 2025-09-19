<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(version: '1.0.0', title: 'Simple CRUD API Documentation', description: 'Dokumentasi API untuk Simple CRUD')]
class AttrDocs
{
    #[OA\Get(path: '/api/v1/hello', summary: 'Hello', tags: ['General'], responses: [new OA\Response(response: 200, description: 'ok')])]
    public function hello() {}
}



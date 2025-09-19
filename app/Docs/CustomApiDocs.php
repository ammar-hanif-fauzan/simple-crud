<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(version: '1.0.0', title: 'Simple CRUD API Documentation', description: 'Dokumentasi API untuk Simple CRUD')]
#[OA\SecurityScheme(securityScheme: 'sanctum', type: 'apiKey', name: 'Authorization', in: 'header', description: 'Enter token as: Bearer <token>')]
#[OA\Tag(name: 'Auth', description: 'Authentication related endpoints')]
#[OA\Tag(name: 'People', description: 'People management endpoints')]
#[OA\Tag(name: 'PhoneNumber', description: 'Phone number management endpoints')]
#[OA\Tag(name: 'Hobbies', description: 'Hobbies management endpoints')]
class CustomApiDocs
{
    #[OA\Get(path: '/api/v1/hello', tags: ['General'], summary: 'Hello World endpoint (dummy, always present)',
        responses: [new OA\Response(response: 200, description: 'Hello World response')]
    )]
    public function hello() {}

    #[OA\Post(path: '/api/v1/register', tags: ['Auth'], summary: 'Register a new user',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['name','email','password','password_confirmation'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'User'),
                new OA\Property(property: 'email', type: 'string', example: 'user@example.com'),
                new OA\Property(property: 'password', type: 'string', example: 'password'),
                new OA\Property(property: 'password_confirmation', type: 'string', example: 'password'),
            ]
        )),
        responses: [new OA\Response(response: 200, description: 'User registered successfully')]
    )]
    public function register() {}

    #[OA\Post(path: '/api/v1/login', tags: ['Auth'], summary: 'Login user and get token',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['email','password'],
            properties: [
                new OA\Property(property: 'email', type: 'string', example: 'user@example.com'),
                new OA\Property(property: 'password', type: 'string', example: 'password'),
            ]
        )),
        responses: [new OA\Response(response: 200, description: 'User logged in successfully')]
    )]
    public function login() {}

    #[OA\Post(path: '/api/v1/logout', tags: ['Auth'], summary: 'Logout user (requires Bearer token)',
        responses: [new OA\Response(response: 200, description: 'User logged out successfully')]
    )]
    public function logout() {}

    #[OA\Get(path: '/api/v1/people', tags: ['People'], summary: 'List all people',
        responses: [new OA\Response(response: 200, description: 'List of people')]
    )]
    public function peopleIndex() {}

    #[OA\Post(path: '/api/v1/people', tags: ['People'], summary: 'Create a new person',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['name','id_number','hobby_id'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'John Doe'),
                new OA\Property(property: 'id_number', type: 'string', example: '123456'),
                new OA\Property(property: 'hobby_id', type: 'integer', example: 1),
            ]
        )),
        responses: [new OA\Response(response: 201, description: 'Person created')]
    )]
    public function peopleStore() {}

    #[OA\Get(path: '/api/v1/people/{id}', tags: ['People'], summary: 'Show person by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Person detail')]
    )]
    public function peopleShow() {}

    #[OA\Put(path: '/api/v1/people/{id}', tags: ['People'], summary: 'Update person by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['name','id_number','hobby_id'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Jane Doe'),
                new OA\Property(property: 'id_number', type: 'string', example: '654321'),
                new OA\Property(property: 'hobby_id', type: 'integer', example: 2),
            ]
        )),
        responses: [new OA\Response(response: 200, description: 'Person updated')]
    )]
    public function peopleUpdate() {}

    #[OA\Delete(path: '/api/v1/people/{id}', tags: ['People'], summary: 'Delete person by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Person deleted')]
    )]
    public function peopleDelete() {}

    #[OA\Get(path: '/api/v1/phone-number', tags: ['PhoneNumber'], summary: 'List all phone numbers',
        responses: [new OA\Response(response: 200, description: 'List of phone numbers')]
    )]
    public function phoneIndex() {}

    #[OA\Post(path: '/api/v1/phone-number', tags: ['PhoneNumber'], summary: 'Create a new phone number',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['people_id','phone_number'],
            properties: [
                new OA\Property(property: 'people_id', type: 'integer', example: 1),
                new OA\Property(property: 'phone_number', type: 'string', example: '08123456789'),
            ]
        )),
        responses: [new OA\Response(response: 201, description: 'Phone number created')]
    )]
    public function phoneStore() {}

    #[OA\Get(path: '/api/v1/phone-number/{id}', tags: ['PhoneNumber'], summary: 'Show phone number by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Phone number detail')]
    )]
    public function phoneShow() {}

    #[OA\Put(path: '/api/v1/phone-number/{id}', tags: ['PhoneNumber'], summary: 'Update phone number by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['people_id','phone_number'],
            properties: [
                new OA\Property(property: 'people_id', type: 'integer', example: 1),
                new OA\Property(property: 'phone_number', type: 'string', example: '08987654321'),
            ]
        )),
        responses: [new OA\Response(response: 200, description: 'Phone number updated')]
    )]
    public function phoneUpdate() {}

    #[OA\Delete(path: '/api/v1/phone-number/{id}', tags: ['PhoneNumber'], summary: 'Delete phone number by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Phone number deleted')]
    )]
    public function phoneDelete() {}

    #[OA\Get(path: '/api/v1/hobbies', tags: ['Hobbies'], summary: 'List all hobbies',
        responses: [new OA\Response(response: 200, description: 'List of hobbies')]
    )]
    public function hobbyIndex() {}

    #[OA\Post(path: '/api/v1/hobbies', tags: ['Hobbies'], summary: 'Create a new hobby',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Membaca'),
            ]
        )),
        responses: [new OA\Response(response: 201, description: 'Hobby created')]
    )]
    public function hobbyStore() {}

    #[OA\Get(path: '/api/v1/hobbies/{id}', tags: ['Hobbies'], summary: 'Show hobby by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Hobby detail')]
    )]
    public function hobbyShow() {}

    #[OA\Put(path: '/api/v1/hobbies/{id}', tags: ['Hobbies'], summary: 'Update hobby by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(
            required: ['name'],
            properties: [
                new OA\Property(property: 'name', type: 'string', example: 'Menulis'),
            ]
        )),
        responses: [new OA\Response(response: 200, description: 'Hobby updated')]
    )]
    public function hobbyUpdate() {}

    #[OA\Delete(path: '/api/v1/hobbies/{id}', tags: ['Hobbies'], summary: 'Delete hobby by ID',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Hobby deleted')]
    )]
    public function hobbyDelete() {}
}

 
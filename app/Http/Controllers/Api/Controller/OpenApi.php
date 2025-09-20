<?php

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *   @OA\Info(
 *     version="1.0.0",
 *     title="Simple CRUD API Documentation",
 *     description="Dokumentasi API untuk Simple CRUD - People, Hobbies, Phone Numbers, dan Authentication"
 *   ),
 *   @OA\Server(
 *     url="http://localhost:8000",
 *     description="Development Server"
 *   ),
 *   @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/hello",
 *   @OA\Get(
 *     summary="Hello World",
 *     description="Test endpoint untuk mengecek API berjalan",
 *     tags={"Test"},
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="Hello, Happy World!")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/people",
 *   @OA\Get(
 *     summary="Get all people",
 *     description="Mengambil daftar semua orang dengan relasi idCard, hobbies, dan phoneNumbers",
 *     tags={"People"},
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="People retrieved successfully"),
 *         @OA\Property(property="data", type="object",
 *           @OA\Property(property="current_page", type="integer"),
 *           @OA\Property(property="data", type="array",
 *             @OA\Items(
 *               @OA\Property(property="id", type="integer"),
 *               @OA\Property(property="name", type="string"),
 *               @OA\Property(property="created_at", type="string", format="datetime"),
 *               @OA\Property(property="updated_at", type="string", format="datetime"),
 *               @OA\Property(property="id_card", type="object"),
 *               @OA\Property(property="hobbies", type="array", @OA\Items(type="object")),
 *               @OA\Property(property="phone_numbers", type="array", @OA\Items(type="object"))
 *             )
 *           ),
 *           @OA\Property(property="first_page_url", type="string"),
 *           @OA\Property(property="from", type="integer"),
 *           @OA\Property(property="last_page", type="integer"),
 *           @OA\Property(property="last_page_url", type="string"),
 *           @OA\Property(property="links", type="array", @OA\Items(type="object")),
 *           @OA\Property(property="next_page_url", type="string"),
 *           @OA\Property(property="path", type="string"),
 *           @OA\Property(property="per_page", type="integer"),
 *           @OA\Property(property="prev_page_url", type="string"),
 *           @OA\Property(property="to", type="integer"),
 *           @OA\Property(property="total", type="integer")
 *         )
 *       )
 *     ),
 *     @OA\Response(
 *       response=500,
 *       description="Internal Server Error",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Failed to retrieve people"),
 *         @OA\Property(property="error", type="string")
 *       )
 *     )
 *   ),
 *   @OA\Post(
 *     summary="Create new person",
 *     description="Membuat orang baru dengan idCard, hobbies, dan phone numbers (bisa lebih dari satu)",
 *     tags={"People"},
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         required={"name", "id_number", "hobby_id"},
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="id_number", type="string", example="1234567890"),
 *         @OA\Property(property="hobby_id", type="array", @OA\Items(type="integer"), example={1, 2}),
 *         @OA\Property(property="phone_numbers", type="array", @OA\Items(type="string"), example={"081234567890", "081234567891"}, description="Array of phone numbers (optional)")
 *       )
 *     ),
 *     @OA\Response(
 *       response=201,
 *       description="Person created successfully",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="Person created successfully"),
 *         @OA\Property(property="data", type="object",
 *           @OA\Property(property="id", type="integer"),
 *           @OA\Property(property="name", type="string"),
 *           @OA\Property(property="id_card", type="object"),
 *           @OA\Property(property="hobbies", type="array", @OA\Items(type="object")),
 *           @OA\Property(property="phone_numbers", type="array", @OA\Items(type="object"))
 *         )
 *       )
 *     ),
 *     @OA\Response(
 *       response=422,
 *       description="Validation failed",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Validation failed"),
 *         @OA\Property(property="errors", type="object")
 *       )
 *     ),
 *     @OA\Response(
 *       response=500,
 *       description="Internal Server Error",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Failed to create person"),
 *         @OA\Property(property="error", type="string")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/people/{id}",
 *   @OA\Get(
 *     summary="Get person by ID",
 *     description="Mengambil detail orang berdasarkan ID",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string")
 *       )
 *     )
 *   ),
 *   @OA\Put(
 *     summary="Update person",
 *     description="Update data orang",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="name", type="string")
 *       )
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Updated",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string"),
 *         @OA\Property(property="data", type="object")
 *       )
 *     )
 *   ),
 *   @OA\Delete(
 *     summary="Delete person",
 *     description="Hapus orang",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Deleted",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/hobbies",
 *   @OA\Get(
 *     summary="Get all hobbies",
 *     description="Mengambil daftar semua hobby",
 *     tags={"Hobbies"},
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="current_page", type="integer"),
 *         @OA\Property(property="data", type="array",
 *           @OA\Items(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="created_at", type="string", format="datetime"),
 *             @OA\Property(property="updated_at", type="string", format="datetime")
 *           )
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Post(
 *     summary="Create new hobby",
 *     description="Membuat hobby baru",
 *     tags={"Hobbies"},
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="Reading")
 *       )
 *     ),
 *     @OA\Response(
 *       response=201,
 *       description="Hobby created successfully",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="Hobby created successfully"),
 *         @OA\Property(property="data", type="object")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/hobbies/{id}",
 *   @OA\Get(
 *     summary="Get hobby by ID",
 *     description="Mengambil detail hobby berdasarkan ID",
 *     tags={"Hobbies"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string")
 *       )
 *     )
 *   ),
 *   @OA\Put(
 *     summary="Update hobby",
 *     description="Update data hobby",
 *     tags={"Hobbies"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="name", type="string")
 *       )
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Updated",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string"),
 *         @OA\Property(property="data", type="object")
 *       )
 *     )
 *   ),
 *   @OA\Delete(
 *     summary="Delete hobby",
 *     description="Hapus hobby",
 *     tags={"Hobbies"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Deleted",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/phone-number",
 *   @OA\Get(
 *     summary="Get all phone numbers",
 *     description="Mengambil daftar semua nomor telepon dengan relasi people",
 *     tags={"Phone Numbers"},
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="current_page", type="integer"),
 *         @OA\Property(property="data", type="array",
 *           @OA\Items(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="phone_number", type="string"),
 *             @OA\Property(property="people_id", type="integer"),
 *             @OA\Property(property="created_at", type="string", format="datetime"),
 *             @OA\Property(property="updated_at", type="string", format="datetime")
 *           )
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Post(
 *     summary="Create new phone number",
 *     description="Membuat nomor telepon baru",
 *     tags={"Phone Numbers"},
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="people_id", type="integer", example=1),
 *         @OA\Property(property="phone_number", type="string", example="081234567890")
 *       )
 *     ),
 *     @OA\Response(
 *       response=201,
 *       description="Phone number created successfully",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="Phone number created successfully"),
 *         @OA\Property(property="data", type="object")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/phone-number/{id}",
 *   @OA\Get(
 *     summary="Get phone number by ID",
 *     description="Mengambil detail nomor telepon berdasarkan ID",
 *     tags={"Phone Numbers"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="phone_number", type="string"),
 *         @OA\Property(property="people_id", type="integer")
 *       )
 *     )
 *   ),
 *   @OA\Put(
 *     summary="Update phone number",
 *     description="Update data nomor telepon",
 *     tags={"Phone Numbers"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="people_id", type="integer"),
 *         @OA\Property(property="phone_number", type="string")
 *       )
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Updated",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string"),
 *         @OA\Property(property="data", type="object")
 *       )
 *     )
 *   ),
 *   @OA\Delete(
 *     summary="Delete phone number",
 *     description="Hapus nomor telepon",
 *     tags={"Phone Numbers"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Deleted",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/register",
 *   @OA\Post(
 *     summary="Register new user",
 *     description="Mendaftarkan user baru",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", example="john@example.com"),
 *         @OA\Property(property="password", type="string", example="password123"),
 *         @OA\Property(property="password_confirmation", type="string", example="password123")
 *       )
 *     ),
 *     @OA\Response(
 *       response=201,
 *       description="User registered successfully",
 *       @OA\JsonContent(
 *         @OA\Property(property="user", type="object"),
 *         @OA\Property(property="token", type="string")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/login",
 *   @OA\Post(
 *     summary="Login user",
 *     description="Login user dengan email dan password",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="email", type="string", example="user@example.com"),
 *         @OA\Property(property="password", type="string", example="password123")
 *       )
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Login successful",
 *       @OA\JsonContent(
 *         @OA\Property(property="user", type="object"),
 *         @OA\Property(property="token", type="string")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/logout",
 *   @OA\Post(
 *     summary="Logout user",
 *     description="Logout user dan hapus token",
 *     tags={"Authentication"},
 *     @OA\Response(
 *       response=200,
 *       description="Logout successful",
 *       @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="Logged out successfully")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/people/{id}/phone-numbers",
 *   @OA\Get(
 *     summary="Get all phone numbers for a person",
 *     description="Mengambil semua nomor telepon milik seseorang",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="Phone numbers retrieved successfully"),
 *         @OA\Property(property="data", type="object",
 *           @OA\Property(property="person", type="object"),
 *           @OA\Property(property="phone_numbers", type="array", @OA\Items(type="object"))
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Post(
 *     summary="Add phone number to a person",
 *     description="Menambah nomor telepon untuk seseorang",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="phone_number", type="string", example="081234567890")
 *       )
 *     ),
 *     @OA\Response(
 *       response=201,
 *       description="Phone number added successfully",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="Phone number added successfully"),
 *         @OA\Property(property="data", type="object")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/people/{id}/phone-numbers/{phone_id}",
 *   @OA\Delete(
 *     summary="Remove phone number from a person",
 *     description="Menghapus nomor telepon dari seseorang",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *       name="phone_id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Phone number removed successfully",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="Phone number removed successfully")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/people/{id}/hobbies",
 *   @OA\Get(
 *     summary="Get all hobbies for a person",
 *     description="Mengambil semua hobby milik seseorang",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Success",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="Hobbies retrieved successfully"),
 *         @OA\Property(property="data", type="object",
 *           @OA\Property(property="person", type="object"),
 *           @OA\Property(property="hobbies", type="array", @OA\Items(type="object"))
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Post(
 *     summary="Add hobby to a person",
 *     description="Menambah hobby untuk seseorang",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         @OA\Property(property="hobby_id", type="integer", example=1)
 *       )
 *     ),
 *     @OA\Response(
 *       response=201,
 *       description="Hobby added successfully",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="Hobby added successfully"),
 *         @OA\Property(property="data", type="object")
 *       )
 *     )
 *   )
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/people/{id}/hobbies/{hobby_id}",
 *   @OA\Delete(
 *     summary="Remove hobby from a person",
 *     description="Menghapus hobby dari seseorang",
 *     tags={"People"},
 *     @OA\Parameter(
 *       name="id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *       name="hobby_id",
 *       in="path",
 *       required=true,
 *       @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Hobby removed successfully",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="Hobby removed successfully")
 *       )
 *     )
 *   )
 * )
 */
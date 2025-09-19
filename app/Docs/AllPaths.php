<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Simple CRUD API Documentation", version="1.0.0", description="Dokumentasi API untuk Simple CRUD")
 * @OA\Tag(name="Auth", description="Authentication related endpoints")
 * @OA\Tag(name="People", description="People management endpoints")
 * @OA\Tag(name="PhoneNumber", description="Phone number management endpoints")
 * @OA\Tag(name="Hobbies", description="Hobbies management endpoints")
 *
 * @OA\PathItem(path="/api/v1/hello",
 *   @OA\Get(tags={"General"}, summary="Hello",
 *     @OA\Response(response=200, description="ok")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/register",
 *   @OA\Post(tags={"Auth"}, summary="Register a new user",
 *     @OA\RequestBody(required=true,
 *       @OA\JsonContent(required={"name","email","password","password_confirmation"},
 *         @OA\Property(property="name", type="string", example="User"),
 *         @OA\Property(property="email", type="string", example="user@example.com"),
 *         @OA\Property(property="password", type="string", example="password"),
 *         @OA\Property(property="password_confirmation", type="string", example="password")
 *       )
 *     ),
 *     @OA\Response(response=200, description="User registered successfully")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/login",
 *   @OA\Post(tags={"Auth"}, summary="Login user and get token",
 *     @OA\RequestBody(required=true,
 *       @OA\JsonContent(required={"email","password"},
 *         @OA\Property(property="email", type="string", example="user@example.com"),
 *         @OA\Property(property="password", type="string", example="password")
 *       )
 *     ),
 *     @OA\Response(response=200, description="User logged in successfully")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/logout",
 *   @OA\Post(tags={"Auth"}, summary="Logout user (requires Bearer token)",
 *     security={{"sanctum":{}}},
 *     @OA\Response(response=200, description="User logged out successfully")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/people",
 *   @OA\Get(tags={"People"}, summary="List all people",
 *     @OA\Response(response=200, description="List of people")
 *   ),
 *   @OA\Post(tags={"People"}, summary="Create a new person",
 *     @OA\RequestBody(required=true,
 *       @OA\JsonContent(required={"name","id_number","hobby_id"},
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="id_number", type="string", example="123456"),
 *         @OA\Property(property="hobby_id", type="integer", example=1)
 *       )
 *     ),
 *     @OA\Response(response=201, description="Person created")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/people/{id}",
 *   @OA\Get(tags={"People"}, summary="Show person by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Person detail")
 *   ),
 *   @OA\Put(tags={"People"}, summary="Update person by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *       @OA\JsonContent(required={"name","id_number","hobby_id"},
 *         @OA\Property(property="name", type="string", example="Jane Doe"),
 *         @OA\Property(property="id_number", type="string", example="654321"),
 *         @OA\Property(property="hobby_id", type="integer", example=2)
 *       )
 *     ),
 *     @OA\Response(response=200, description="Person updated")
 *   ),
 *   @OA\Delete(tags={"People"}, summary="Delete person by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Person deleted")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/phone-number",
 *   @OA\Get(tags={"PhoneNumber"}, summary="List all phone numbers",
 *     @OA\Response(response=200, description="List of phone numbers")
 *   ),
 *   @OA\Post(tags={"PhoneNumber"}, summary="Create a new phone number",
 *     @OA\RequestBody(required=true,
 *       @OA\JsonContent(required={"people_id","phone_number"},
 *         @OA\Property(property="people_id", type="integer", example=1),
 *         @OA\Property(property="phone_number", type="string", example="08123456789")
 *       )
 *     ),
 *     @OA\Response(response=201, description="Phone number created")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/phone-number/{id}",
 *   @OA\Get(tags={"PhoneNumber"}, summary="Show phone number by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Phone number detail")
 *   ),
 *   @OA\Put(tags={"PhoneNumber"}, summary="Update phone number by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *       @OA\JsonContent(required={"people_id","phone_number"},
 *         @OA\Property(property="people_id", type="integer", example=1),
 *         @OA\Property(property="phone_number", type="string", example="08987654321")
 *       )
 *     ),
 *     @OA\Response(response=200, description="Phone number updated")
 *   ),
 *   @OA\Delete(tags={"PhoneNumber"}, summary="Delete phone number by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Phone number deleted")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/hobbies",
 *   @OA\Get(tags={"Hobbies"}, summary="List all hobbies",
 *     @OA\Response(response=200, description="List of hobbies")
 *   ),
 *   @OA\Post(tags={"Hobbies"}, summary="Create a new hobby",
 *     @OA\RequestBody(required=true,
 *       @OA\JsonContent(required={"name"},
 *         @OA\Property(property="name", type="string", example="Membaca")
 *       )
 *     ),
 *     @OA\Response(response=201, description="Hobby created")
 *   )
 * )
 *
 * @OA\PathItem(path="/api/v1/hobbies/{id}",
 *   @OA\Get(tags={"Hobbies"}, summary="Show hobby by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Hobby detail")
 *   ),
 *   @OA\Put(tags={"Hobbies"}, summary="Update hobby by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *       @OA\JsonContent(required={"name"},
 *         @OA\Property(property="name", type="string", example="Menulis")
 *       )
 *     ),
 *     @OA\Response(response=200, description="Hobby updated")
 *   ),
 *   @OA\Delete(tags={"Hobbies"}, summary="Delete hobby by ID",
 *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
 *     @OA\Response(response=200, description="Hobby deleted")
 *   )
 * )
 */



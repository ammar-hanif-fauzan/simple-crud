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
 * @OA\Get(
 *   path="/api/v1/hello",
 *   summary="Hello World",
 *   description="Test endpoint untuk mengecek API berjalan",
 *   tags={"Test"},
 *   @OA\Response(
 *     response=200,
 *     description="Success",
 *     @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Hello, Happy World!")
 *     )
 *   )
 * )
 */
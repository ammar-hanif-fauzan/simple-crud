<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Simple CRUD API Documentation",
 *   description="Dokumentasi API untuk Simple CRUD - People, Hobbies, Phone Numbers, dan Authentication"
 * )
 *
 * @OA\Server(
 *   url="http://localhost:8000",
 *   description="Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 *
 */



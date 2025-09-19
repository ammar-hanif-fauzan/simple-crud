<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger API Documentation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background-color: #007bff;
            color: white;
            padding: 2rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .status-box {
            background: #d4edda;
            color: #155724;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .status-box strong {
            font-size: 1.2rem;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin: 0.5rem;
        }
        
        .btn-primary {
            background: #28a745;
            color: white;
        }
        
        .btn-primary:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .endpoints-list {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .endpoints-list h3 {
            color: #333;
            margin-bottom: 1rem;
            border-bottom: 2px solid #28a745;
            padding-bottom: 0.5rem;
        }
        
        .endpoint-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .endpoint-item:last-child {
            border-bottom: none;
        }
        
        .method {
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
            min-width: 60px;
            text-align: center;
        }
        
        .method-get { background: #28a745; color: white; }
        .method-post { background: #007bff; color: white; }
        .method-put { background: #ffc107; color: black; }
        .method-delete { background: #dc3545; color: white; }
        
        .endpoint-path {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #333;
            flex: 1;
        }
        
        .endpoint-description {
            color: #666;
            font-size: 0.9rem;
        }
        
        .center {
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 10px;
            }
            
            .header {
                padding: 1.5rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .endpoint-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Swagger API Documentation</h1>
            <p>Dokumentasi lengkap untuk semua endpoint API Simple CRUD</p>
        </div>
        
        <div class="status-box">
            <strong>✅ Swagger Documentation Status</strong>
            Swagger documentation sudah berfungsi dengan baik! Semua endpoint sudah ditampilkan di dokumentasi Swagger.<br><br>
            <strong>🎉 Semua Endpoint Tersedia:</strong><br>
            • Authentication (Register, Login, Logout)<br>
            • People (CRUD operations)<br>
            • Hobbies (CRUD operations)<br>
            • Phone Numbers (CRUD operations)<br>
            • Test endpoint<br><br>
            <strong>📖 Akses Dokumentasi:</strong><br>
            Dokumentasi Swagger tersedia di <a href="/docs" target="_blank" style="color: #155724; text-decoration: underline;">/docs</a>
        </div>
        
        <div class="endpoints-list">
            <h3>📋 Daftar Semua Endpoint</h3>
            
            <div class="endpoint-item">
                <span class="method method-get">GET</span>
                <span class="endpoint-path">/api/v1/hello</span>
                <span class="endpoint-description">Test endpoint untuk mengecek API berjalan</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-get">GET</span>
                <span class="endpoint-path">/api/v1/people</span>
                <span class="endpoint-description">Mengambil daftar semua orang</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-post">POST</span>
                <span class="endpoint-path">/api/v1/people</span>
                <span class="endpoint-description">Membuat orang baru</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-get">GET</span>
                <span class="endpoint-path">/api/v1/people/{id}</span>
                <span class="endpoint-description">Mengambil detail orang berdasarkan ID</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-put">PUT</span>
                <span class="endpoint-path">/api/v1/people/{id}</span>
                <span class="endpoint-description">Update data orang</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-delete">DELETE</span>
                <span class="endpoint-path">/api/v1/people/{id}</span>
                <span class="endpoint-description">Hapus orang</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-get">GET</span>
                <span class="endpoint-path">/api/v1/hobbies</span>
                <span class="endpoint-description">Mengambil daftar semua hobby</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-post">POST</span>
                <span class="endpoint-path">/api/v1/hobbies</span>
                <span class="endpoint-description">Membuat hobby baru</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-get">GET</span>
                <span class="endpoint-path">/api/v1/hobbies/{id}</span>
                <span class="endpoint-description">Mengambil detail hobby berdasarkan ID</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-put">PUT</span>
                <span class="endpoint-path">/api/v1/hobbies/{id}</span>
                <span class="endpoint-description">Update data hobby</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-delete">DELETE</span>
                <span class="endpoint-path">/api/v1/hobbies/{id}</span>
                <span class="endpoint-description">Hapus hobby</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-get">GET</span>
                <span class="endpoint-path">/api/v1/phone-number</span>
                <span class="endpoint-description">Mengambil daftar semua nomor telepon</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-post">POST</span>
                <span class="endpoint-path">/api/v1/phone-number</span>
                <span class="endpoint-description">Membuat nomor telepon baru</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-get">GET</span>
                <span class="endpoint-path">/api/v1/phone-number/{id}</span>
                <span class="endpoint-description">Mengambil detail nomor telepon berdasarkan ID</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-put">PUT</span>
                <span class="endpoint-path">/api/v1/phone-number/{id}</span>
                <span class="endpoint-description">Update data nomor telepon</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-delete">DELETE</span>
                <span class="endpoint-path">/api/v1/phone-number/{id}</span>
                <span class="endpoint-description">Hapus nomor telepon</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-post">POST</span>
                <span class="endpoint-path">/api/v1/register</span>
                <span class="endpoint-description">Mendaftarkan user baru</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-post">POST</span>
                <span class="endpoint-path">/api/v1/login</span>
                <span class="endpoint-description">Login user dengan email dan password</span>
            </div>
            
            <div class="endpoint-item">
                <span class="method method-post">POST</span>
                <span class="endpoint-path">/api/v1/logout</span>
                <span class="endpoint-description">Logout user dan invalidate token</span>
            </div>
        </div>
        
        <div class="center">
            <a href="/docs" class="btn btn-primary">📖 Buka Swagger Documentation</a>
            <a href="/api-docs" class="btn btn-secondary">📚 Buka Scramble Manager</a>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simple CRUD API Documentation</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        .controls {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .filter-section {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .filter-section label {
            font-weight: 600;
            color: #555;
        }
        
        .filter-section select {
            padding: 0.5rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 5px;
            font-size: 1rem;
            background: white;
        }
        
        .filter-section select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5a6fd8;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .endpoints-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .endpoint-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            position: relative;
        }
        
        .endpoint-card:hover {
            transform: translateY(-5px);
        }
        
        .endpoint-card.selected {
            border: 2px solid #667eea;
            background: #f8f9ff;
        }
        
        .endpoint-checkbox {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        
        .endpoint-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .method {
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .method-get { background: #28a745; color: white; }
        .method-post { background: #007bff; color: white; }
        .method-put { background: #ffc107; color: black; }
        .method-delete { background: #dc3545; color: white; }
        
        .endpoint-path {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #333;
        }
        
        .endpoint-description {
            color: #666;
            line-height: 1.5;
        }
        
        .category-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin: 2rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #667eea;
        }
        
        .loading {
            text-align: center;
            padding: 2rem;
            color: #666;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 5px;
            margin: 1rem 0;
        }
        
        .info-box {
            background: #d1ecf1;
            color: #0c5460;
            padding: 1rem;
            border-radius: 5px;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Simple CRUD API Documentation</h1>
            <p>Dokumentasi lengkap untuk API Simple CRUD - People, Hobbies, Phone Numbers, dan Authentication</p>
        </div>
        
        <div class="controls">
            <div class="filter-section">
                <label for="categoryFilter">Filter Kategori:</label>
                <select id="categoryFilter">
                    <option value="all">Semua Endpoint</option>
                    <option value="Authentication">Authentication</option>
                    <option value="People">People</option>
                    <option value="Hobbies">Hobbies</option>
                    <option value="Phone Numbers">Phone Numbers</option>
                    <option value="Test">Test</option>
                </select>
                <button class="btn btn-primary" onclick="loadEndpoints()">Filter</button>
                <button class="btn btn-secondary" onclick="loadAllEndpoints()">Reset</button>
            </div>
            <div class="filter-section" style="margin-top: 1rem;">
                <button class="btn btn-primary" onclick="selectAll()">Pilih Semua</button>
                <button class="btn btn-secondary" onclick="deselectAll()">Batal Pilih Semua</button>
                <button class="btn btn-primary" onclick="applySelection()" style="background: #28a745;">Terapkan ke /docs/api</button>
                <span id="selectionCount" style="margin-left: 1rem; font-weight: bold; color: #667eea;"></span>
            </div>
        </div>
        
        <div class="info-box">
            <strong>Cara Menggunakan:</strong><br>
            1. Gunakan filter untuk melihat endpoint berdasarkan kategori<br>
            2. Centang checkbox di card endpoint yang ingin ditampilkan di /docs/api<br>
            3. Klik "Terapkan ke /docs/api" untuk menyimpan pilihan<br>
            4. Dokumentasi Scramble akan otomatis menampilkan hanya endpoint yang dipilih
        </div>
        
        <div id="endpointsContainer">
            <div class="loading">Memuat endpoint...</div>
        </div>
    </div>

    <script>
        let allEndpoints = {};
        let selectedEndpoints = new Set();
        
        // Load all endpoints on page load
        window.onload = function() {
            loadAllEndpoints();
            updateSelectionCount();
        };
        
        async function loadAllEndpoints() {
            try {
                const response = await fetch('/api/v1/docs/config');
                const data = await response.json();
                allEndpoints = data.available_endpoints;
                displayEndpoints(allEndpoints);
            } catch (error) {
                document.getElementById('endpointsContainer').innerHTML = 
                    '<div class="error">Error loading endpoints: ' + error.message + '</div>';
            }
        }
        
        async function loadEndpoints() {
            const category = document.getElementById('categoryFilter').value;
            
            if (category === 'all') {
                displayEndpoints(allEndpoints);
                return;
            }
            
            try {
                const response = await fetch(`/api/v1/docs/filter?category=${encodeURIComponent(category)}`);
                const data = await response.json();
                displayEndpoints(data);
            } catch (error) {
                document.getElementById('endpointsContainer').innerHTML = 
                    '<div class="error">Error loading filtered endpoints: ' + error.message + '</div>';
            }
        }
        
        function displayEndpoints(endpoints) {
            const container = document.getElementById('endpointsContainer');
            
            if (Object.keys(endpoints).length === 0) {
                container.innerHTML = '<div class="error">Tidak ada endpoint yang ditemukan.</div>';
                return;
            }
            
            let html = '';
            
            for (const [category, categoryEndpoints] of Object.entries(endpoints)) {
                html += `<div class="category-title">${category}</div>`;
                html += '<div class="endpoints-grid">';
                
                for (const [endpoint, description] of Object.entries(categoryEndpoints)) {
                    const [method, path] = endpoint.split(' ');
                    const methodClass = `method-${method.toLowerCase()}`;
                    const isSelected = selectedEndpoints.has(endpoint);
                    const cardClass = isSelected ? 'endpoint-card selected' : 'endpoint-card';
                    
                    html += `
                        <div class="${cardClass}" data-endpoint="${endpoint}">
                            <input type="checkbox" class="endpoint-checkbox" ${isSelected ? 'checked' : ''} 
                                   onchange="toggleEndpoint('${endpoint}')">
                            <div class="endpoint-header">
                                <span class="method ${methodClass}">${method}</span>
                                <span class="endpoint-path">${path}</span>
                            </div>
                            <div class="endpoint-description">${description}</div>
                        </div>
                    `;
                }
                
                html += '</div>';
            }
            
            container.innerHTML = html;
        }
        
        function toggleEndpoint(endpoint) {
            if (selectedEndpoints.has(endpoint)) {
                selectedEndpoints.delete(endpoint);
            } else {
                selectedEndpoints.add(endpoint);
            }
            
            // Update card appearance
            const card = document.querySelector(`[data-endpoint="${endpoint}"]`);
            if (selectedEndpoints.has(endpoint)) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
            
            updateSelectionCount();
        }
        
        function selectAll() {
            // Get all visible endpoints
            const cards = document.querySelectorAll('.endpoint-card');
            cards.forEach(card => {
                const endpoint = card.getAttribute('data-endpoint');
                if (endpoint) {
                    selectedEndpoints.add(endpoint);
                    card.classList.add('selected');
                    const checkbox = card.querySelector('.endpoint-checkbox');
                    if (checkbox) checkbox.checked = true;
                }
            });
            updateSelectionCount();
        }
        
        function deselectAll() {
            selectedEndpoints.clear();
            const cards = document.querySelectorAll('.endpoint-card');
            cards.forEach(card => {
                card.classList.remove('selected');
                const checkbox = card.querySelector('.endpoint-checkbox');
                if (checkbox) checkbox.checked = false;
            });
            updateSelectionCount();
        }
        
        function updateSelectionCount() {
            const count = selectedEndpoints.size;
            const countElement = document.getElementById('selectionCount');
            countElement.textContent = `${count} endpoint dipilih`;
        }
        
        async function applySelection() {
            if (selectedEndpoints.size === 0) {
                alert('Pilih minimal 1 endpoint untuk ditampilkan di /docs/api');
                return;
            }
            
            try {
                const response = await fetch('/api/v1/docs/selection', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        selected_endpoints: Array.from(selectedEndpoints)
                    })
                });
                
                if (response.ok) {
                    alert(`Berhasil! ${selectedEndpoints.size} endpoint telah dipilih untuk ditampilkan di /docs/api`);
                    // Open /docs/api in new tab
                    window.open('/docs/api', '_blank');
                } else {
                    alert('Gagal menyimpan pilihan endpoint');
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        }
    </script>
</body>
</html>

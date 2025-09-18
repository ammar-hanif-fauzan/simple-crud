@extends('layouts.app')

@section('title', 'API Tester')
@section('body')
<style>
    .api-tester-container {
        max-width: 950px;
        margin: 2rem auto;
        background: #f8fafc;
        border-radius: 12px;
        box-shadow: 0 2px 16px #0002;
        padding: 2.5rem 2.5rem 2rem 2.5rem;
        font-family: 'Segoe UI', Arial, sans-serif;
    }
    .api-tester-title {
        font-size: 2.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #2c3e50;
        letter-spacing: -1px;
    }
    .api-endpoint-list {
        max-height: 220px;
        overflow-y: auto;
        border: 1px solid #e0e0e0;
        border-radius: 7px;
        margin-bottom: 1.5rem;
        background: #f4f7fa;
    }
    .api-endpoint-list li {
        padding: 0.5rem 1rem;
        border-bottom: 1px solid #f0f0f0;
        font-size: 1rem;
        display: flex;
        align-items: center;
    }
    .api-endpoint-list li:last-child { border-bottom: none; }
    .api-route-link {
        text-decoration: none;
        color: #2980b9;
        transition: color 0.2s;
        flex: 1;
    }
    .api-route-link:hover { color: #1abc9c; }
    .api-method {
        display: inline-block;
        min-width: 55px;
        text-align: center;
        font-weight: bold;
        border-radius: 4px;
        margin-right: 10px;
        color: #fff;
        background: #888;
        font-size: 0.95em;
    }
    .api-method[data-method="GET"] { background: #27ae60; }
    .api-method[data-method="POST"] { background: #2980b9; }
    .api-method[data-method="PUT"] { background: #f39c12; }
    .api-method[data-method="PATCH"] { background: #8e44ad; }
    .api-method[data-method="DELETE"] { background: #e74c3c; }
    .api-tester-form {
        background: #fff;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.5rem 1.5rem 1.2rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 6px #0001;
    }
    .api-tester-form label { font-weight: 500; }
    .api-tester-form textarea, .api-tester-form input, .api-tester-form select {
        font-family: 'Fira Mono', 'Consolas', monospace;
        font-size: 1em;
        border-radius: 5px;
        border: 1px solid #d0d0d0;
        background: #f8fafc;
        margin-bottom: 0.3rem;
    }
    .api-tester-form textarea:focus, .api-tester-form input:focus, .api-tester-form select:focus {
        outline: 2px solid #2980b9;
        background: #fff;
    }
    .api-tester-form .form-group { margin-bottom: 1.1rem; }
    .api-tester-form button {
        background: #2980b9;
        color: #fff;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 5px;
        font-size: 1.1em;
        font-weight: 500;
        cursor: pointer;
        margin-top: 0.5rem;
        transition: background 0.2s;
        box-shadow: 0 1px 4px #0001;
    }
    .api-tester-form button:hover { background: #1abc9c; }
    .api-response {
        background: #222;
        color: #e0e0e0;
        border-radius: 6px;
        padding: 1rem;
        margin-top: 1.5rem;
        font-size: 1em;
        overflow-x: auto;
        white-space: pre-wrap;
        word-break: break-all;
        box-shadow: 0 1px 6px #0002;
    }
    .api-response-error {
        background: #fff0f0;
        color: #c0392b;
        border: 1.5px solid #e74c3c;
        border-radius: 6px;
        padding: 1rem;
        margin-top: 1.5rem;
        font-size: 1em;
        box-shadow: 0 1px 6px #e74c3c22;
        font-family: 'Fira Mono', 'Consolas', monospace;
    }
    .api-tester-form .row { display: flex; gap: 1rem; }
    .api-tester-form .row > div { flex: 1; }
    .api-doc-panel {
        background: #f4f7fa;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.1rem 1.5rem 1.1rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 4px #0001;
    }
    .api-doc-title {
        font-size: 1.1em;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2980b9;
    }
    .api-doc-detail {
        font-size: 1em;
        color: #222;
        margin-bottom: 0.2rem;
    }
    @media (max-width: 700px) {
        .api-tester-container { padding: 1rem; }
        .api-tester-form .row { flex-direction: column; gap: 0; }
        .api-doc-panel { padding: 1rem; }
    }
</style>
<div class="api-tester-container">
    <div class="api-tester-title">API Tester</div>


    @if(isset($apiRoutes) && count($apiRoutes))
    <div style="margin-bottom:2rem">
        <div style="font-weight:600;margin-bottom:0.5rem;">Daftar API Endpoint</div>
        <ul class="api-endpoint-list" id="api-route-list">
            @foreach($apiRoutes as $route)
                <li>
                    <span class="api-method" data-method="{{ $route['methods'][0] }}">{{ $route['methods'][0] }}</span>
                    <a href="#" class="api-route-link" data-endpoint="/{{ $route['uri'] }}" data-method="{{ $route['methods'][0] }}">
                        /{{ $route['uri'] }}
                        @if($route['name']) <span style="color:#888;font-size:0.95em;">({{ $route['name'] }})</span>@endif
                    </a>
                </li>
            @endforeach
        </ul>
        <div style="font-size:0.95em;color:#888;margin-top:0.3rem;">Klik endpoint untuk autofill ke form tester.</div>
    </div>
    @endif

    <div id="api-doc-panel" class="api-doc-panel" style="display:none">
        <div class="api-doc-title">Endpoint Documentation</div>
        <div class="api-doc-detail" id="doc-method"></div>
        <div class="api-doc-detail" id="doc-url"></div>
        <div class="api-doc-detail" id="doc-desc"></div>
    </div>

    <form method="POST" action="{{ route('manage.api.test') }}" id="api-tester-form" class="api-tester-form">
        @csrf
        <div class="form-group">
            <label for="endpoint">Endpoint URL</label>
            <input type="text" id="endpoint" name="endpoint" value="{{ old('endpoint', $input['endpoint'] ?? '') }}" required style="width:100%;padding:0.5rem;">
        </div>
        <div class="form-group">
            <label for="method">HTTP Method</label>
            <select id="method" name="method" style="width:100%;padding:0.5rem;">
                <option value="GET" {{ (old('method', $input['method'] ?? '') == 'GET') ? 'selected' : '' }}>GET</option>
                <option value="POST" {{ (old('method', $input['method'] ?? '') == 'POST') ? 'selected' : '' }}>POST</option>
                <option value="PUT" {{ (old('method', $input['method'] ?? '') == 'PUT') ? 'selected' : '' }}>PUT</option>
                <option value="PATCH" {{ (old('method', $input['method'] ?? '') == 'PATCH') ? 'selected' : '' }}>PATCH</option>
                <option value="DELETE" {{ (old('method', $input['method'] ?? '') == 'DELETE') ? 'selected' : '' }}>DELETE</option>
            </select>
        </div>
        <div class="row">
            <div>
                <label for="headers">Headers (JSON)</label>
                <textarea id="headers" name="headers" rows="3" style="width:100%;padding:0.5rem;">{{ old('headers', $input['headers'] ?? '') }}</textarea>
            </div>
            <div>
                <label for="body">Body (JSON)</label>
                <textarea id="body" name="body" rows="3" style="width:100%;padding:0.5rem;">{{ old('body', $input['body'] ?? '') }}</textarea>
            </div>
        </div>
        <button type="submit">Test API</button>
    </form>

    @if(isset($result))
        @php
            $isJson = false;
            $json = null;
            if (is_string($result)) {
                $trim = ltrim($result);
                if (str_starts_with($trim, '{') || str_starts_with($trim, '[')) {
                    $json = json_decode($result, true);
                    $isJson = $json !== null;
                }
            }
        @endphp
        @if(str_starts_with($result, 'Request error:'))
            <div class="api-response-error">{{ $result }}</div>
        @else
            <div class="api-response" id="api-response-block">
                @if($isJson)
                    <pre>{{ json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                @else
                    <pre>{{ $result }}</pre>
                @endif
            </div>
        @endif
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Autofill endpoint/method dan tampilkan dokumentasi mini
        document.querySelectorAll('.api-route-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('endpoint').value = this.dataset.endpoint;
                document.getElementById('method').value = this.dataset.method;
                // Mini doc
                document.getElementById('api-doc-panel').style.display = '';
                document.getElementById('doc-method').innerHTML = '<b>Method:</b> ' + this.dataset.method;
                document.getElementById('doc-url').innerHTML = '<b>URL:</b> ' + this.dataset.endpoint;
                var desc = this.closest('li').querySelector('span[style*="color:#888"]');
                document.getElementById('doc-desc').innerHTML = desc ? '<b>Info:</b> ' + desc.textContent : '';
            });
        });
        // Tampilkan doc panel jika sudah autofill
        if(document.getElementById('endpoint').value) {
            document.getElementById('api-doc-panel').style.display = '';
            document.getElementById('doc-method').innerHTML = '<b>Method:</b> ' + document.getElementById('method').value;
            document.getElementById('doc-url').innerHTML = '<b>URL:</b> ' + document.getElementById('endpoint').value;
            document.getElementById('doc-desc').innerHTML = '';
        }
    });
    </script>
</div>
@endsection

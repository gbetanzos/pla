<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shopping App') - Laravel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #f5f5f5; min-height: 100vh; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        header { background: #2c3e50; color: white; padding: 1rem; }
        main { background: white; padding: 2rem; border-radius: 8px; margin-top: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn-primary { background: #3498db; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .form-group textarea { min-height: 100px; }
        .alert { padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .priority-high { border-left: 4px solid #e74c3c; }
        .priority-medium { border-left: 4px solid #f39c12; }
        .priority-low { border-left: 4px solid #27ae60; }
        .items-list { display: flex; flex-direction: column; gap: 0; }
        .items-list-item { display: flex; align-items: flex-start; position: relative; padding: 8px 8px; border-radius: 4px; margin: 2px 0; }
        .items-list-item:hover { background: #f8f9fa; }
        .items-list-item .items-list-item-checkbox { margin-right: 10px; cursor: pointer; }
        .items-list-item.checked { text-decoration: line-through; color: #999; }
        .items-list-item.checked .items-list-item-checkbox { background: #27ae60; }
        .items-list-item.checked .items-list-item-title { text-decoration: line-through; }
    </style>
</head>
<body>
    <header>
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Shopping List</h1>
            <nav>
                <a href="{{ route('shopping-lists.index') }}" class="btn btn-primary">My Lists</a>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Products</a>
                <a href="{{ route('shopping-lists.create') }}" class="btn btn-success" style="margin-left: 10px;">+ New List</a>
            </nav>
        </div>
    </header>
    <main class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>

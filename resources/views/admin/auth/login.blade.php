<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: #242733; color: white; height: 100vh; display: flex; align-items: center; justify-content: center; }</style>
</head>
<body>
    <div class="card p-4 border-0 shadow-lg" style="width: 350px; background: #1a1c23;">
        <h3 class="text-center text-white mb-4">Admin Login</h3>
        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger p-2 small">{{ $errors->first() }}</div>
            @endif
            <div class="mb-3">
                <label class="text-secondary small">Email</label>
                <input type="email" name="email" class="form-control bg-dark text-white border-secondary" required>
            </div>
            <div class="mb-3">
                <label class="text-secondary small">Password</label>
                <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required>
            </div>
            <button class="btn btn-warning w-100 fw-bold">MASUK</button>
        </form>
    </div>
</body>
</html>
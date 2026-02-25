<!DOCTYPE html>
<html>
<head>
    <title>E-Catering PT Craze Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
        <div class="container">
            <a class="navbar-brand" href="#">E-Catering</a>
           <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-link nav-link" style="display: inline; cursor: pointer;">
        <i class="bi bi-box-arrow-right"></i> Logout
    </button>
</form>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>
        </div>
    </nav>
    @yield('content')
</body>
</html>
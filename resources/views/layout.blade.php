<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')|Kanokporn Jeamthong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </link>
</head>

<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('author.dashboard') }}">Kanokporn Jeamthong</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <ul class="navbar-nav ms-auto">
                <div class="navbar-nav">
                    <a class="nav-link active" aria-current="page" href="{{ route('author.dashboard') }}">หน้าแรก</a>
                    <a class="nav-link" href="{{ route('author.about') }}">เกี่ยวกับเรา</a>
                    <a class="nav-link" href="{{ route('author.blog') }}">บทความ</a>
                    <a class="nav-link" href="{{ route('author.claim.create') }}">แจ้งเคลมสินค้าชำรุด</a>
                </div>
            </ul>
        </div>
    </div>
</nav>

<body>
    <div class="container py-4">
        @yield('content')
    </div>
</body>

</html>

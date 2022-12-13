@extends('layouts.app')

@section('content')
<main>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach($productos as $producto)
                <div class="col">
                    <div class="card shadow-sm">
                        <img height="200" src="/foto/{{$producto->imagen}}" alt="Imagen">
                        <div class="card-body">
                            <h1>{{$producto->categoria->nombre}}</h1>
                            <h2>{{$producto->nombre}}</h2>
                            <p>{{$producto->caracteriticas}}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                
                                <small class="text-muted">{{$producto->created_at}}</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</main>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Productos
                    @can('products.create')
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                        Crear
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        @can('products.show')
                                            <a href="{{ route('products.show', $product->id)}}" class="btn btn-dark">Ver</a>
                                        @endcan
                                        @can('products.edit')
                                            <a href="{{ route('products.edit', $product->id)}}" class="btn btn-warning">Editar</a>
                                        @endcan
                                        @can('products.destroy')

                                        {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'DELETE']) !!}
                                            <button class="btn btn-danger">Borrar</button>
                                        {!! Form::close() !!}
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->render() }}
                </div>
                @can('products.show')
                    <div class="card-footer">
                        <example-component can_see_me="false"></example-component>
                    </div>
                @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

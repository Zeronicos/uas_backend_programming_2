@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Products Variants ({{ $product->name }})</h1>
        </div>

        <div>
            <a href="{{ route('admin.product.index') }}" class="btn btn-dark my-3">Go Back</a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h4>Create Option</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product-option.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" id="" class="form-control">
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">Create</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-secondary">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $option)
                                    <tr>
                                        <th>{{ ++$loop->index }}</th>
                                        <td>{{ $option->name }}</td>
                                        <td>{{ currencyPosition($option->price) }}</td>
                                        <td>
                                            <a href='{{ route('admin.product-option.destroy', $option->id) }}'
                                                class='btn btn-danger delete-item mx-1'><i class='far fa-trash-alt'></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($options) === 0)
                                    <tr>
                                        <td colspan="3" class="text-center">No Data Found!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h4>Create Add-Ons</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product-add.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" id="" class="form-control">
                                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input type="text" name="price" id="" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">Create</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-secondary">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adds as $add)
                                    <tr>
                                        <th>{{ ++$loop->index }}</th>
                                        <td>{{ $add->name }}</td>
                                        <td>{{ currencyPosition($add->price) }}</td>
                                        <td>
                                            <a href='{{ route('admin.product-add.destroy', $add->id) }}'
                                                class='btn btn-danger delete-item mx-1'><i class='far fa-trash-alt'></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if (count($adds) === 0)
                                    <tr>
                                        <td colspan="3" class="text-center">No Data Found!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

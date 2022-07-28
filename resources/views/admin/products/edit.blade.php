@extends('admin.layouts.app')
@section('admin-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Product</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <div class="content py-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('products.update', $product->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Product Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ $product->name }}">
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="shortDescription" class="form-label">Short Description</label>
                                    <textarea name="shortDescription" id="shortDescription" cols="30" rows="3"
                                        class="form-control @error('shortDescription') is-invalid @enderror">{{ $product->short_description }}</textarea>
                                </div>
                                @error('shortDescription')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="longDescription" class="form-label">Long Description</label>
                                    <textarea name="longDescription" id="longDescription" cols="30" rows="3"
                                        class="form-control @error('longDescription') is-invalid @enderror">{{ $product->long_description }}</textarea>
                                </div>
                                @error('longDescription')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="regularPrice" class="form-label">Regular Price</label>
                                    <input type="number" class="form-control @error('regularPrice') is-invalid @enderror"
                                        id="regularPrice" name="regularPrice" value="{{ $product->regular_price }}">
                                </div>
                                @error('regularPrice')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="salePrice" class="form-label">Sale Price</label>
                                    <input type="number" class="form-control @error('salePrice') is-invalid @enderror"
                                        id="salePrice" name="salePrice" value="{{ $product->sale_price }}">
                                </div>
                                @error('salePrice')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="sku" class="form-label">SKU</label>
                                    <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                        id="sku" name="sku" value="{{ $product->sku }}">
                                </div>
                                @error('sku')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="stockStatus" class="form-label">Stock Status</label>
                                    <select class="custom-select @error('stockStatus') is-invalid @enderror"
                                        id="stockStatus" name="stockStatus">
                                        <option value="instock"
                                            {{ $product->stock_status == 'instock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="outofstock"
                                            {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Out Of Stock
                                        </option>
                                    </select>
                                </div>
                                @error('stockStatus')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="featured" class="form-label">Featured</label>
                                    <select class="custom-select @error('featured') is-invalid @enderror" id="featured"
                                        name="featured">
                                        <option value="0" {{ $product->stock_status == '0' ? 'selected' : '' }}>No
                                        </option>
                                        <option value="1" {{ $product->stock_status == '1' ? 'selected' : '' }}>Yes
                                        </option>
                                    </select>
                                </div>
                                @error('featured')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        id="quantity" name="quantity" value="{{ $product->quantity }}">
                                </div>
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Product Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image">
                                    <input type="hidden" class="form-control" id="oldImage" name="oldImage"
                                        value="{{ $product->image }}">
                                    <img src="{{ asset($product->image) }}" alt="" width="100px"
                                        class="mt-2">
                                </div>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="custom-select @error('category') is-invalid @enderror" id="category"
                                        name="category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mt-1">Update Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

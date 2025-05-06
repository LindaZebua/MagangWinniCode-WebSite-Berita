@extends('content/layouts/main')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="title-1">Show Category</h2>
                        <div class="card">
                            <div class="card-body">
                                <p><strong>Name:</strong> {{ $category->category_name }}</p>
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
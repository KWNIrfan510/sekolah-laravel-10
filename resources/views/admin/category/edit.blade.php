@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="section">
        <div class="section-header">
            <h1>Edit Kategori</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-folder"></i> Edit Kategori</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" placeholder="Masukkan Nama Kategori" class="form-control @error('name') is-invalid @enderror">

                            @error('name')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mr-1 btn-submit"><i class="fas fa-paper-plane"></i> Update</button>
                        <button type="reset" class="btn btn-warning btn-reset"><i class="fas fa-redo"></i> Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
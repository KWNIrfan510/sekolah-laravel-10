@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="section">
        <div class="section-header">
            <h1>Tambah Role</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-unlock"></i> Tambah Role</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.role.update', $role->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Nama Role</label>
                            <input type="text" name="name" value="{{ old('name', $role->name) }}" placeholder="Masukkan Nama Role" class="form-control @error('title') is-invalid @enderror">

                            @error('name')
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Permissions</label>
                            <br>
                            @foreach ($permissions as $permission)
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}" id="check-{{ $permission->id }}" @if($role->permissions->contains($permission)) checked @endif>
                                    <label class="form-check-label" for="check-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary mr-1 btn-submit"><i class="fa fa-paper-plane"></i> Update</button>
                        <button type="reset" class="btn btn-warning btn-reset"><i class="fas fa-redo"></i> Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
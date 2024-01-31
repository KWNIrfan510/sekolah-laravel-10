@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kategori</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-folder"></i> Kategori</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.category.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('categories.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.category.create') }}" class="btn btn-primary" style="padding-top: 10px"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                @endcan
                                <input type="text" class="form-control" name="q" placeholder="cari berdasarkan nama kategori">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center; width: 6%">No.</th>
                                    <th scope="col">Nama Kategori</th>
                                    <th scope="col" style="text-align: center; width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $no => $category)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no + ($categories->currentPage() - 1) * $categories->perPage() }}</th>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @can('categories.edit')
                                                <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                            @endcan

                                            @can('categories.delete')
                                            <button onclick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $category->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{ $categories->links("vendor.pagination.bootstrap-5") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // ajax Delete
    function Delete(id)
    {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "Apakah Anda Yakin ?",
            text: "Ingin Menghapus Data Ini!!",
            icon: "warning",
            buttons: [
                'Tidak',
                'Ya'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if(isConfirm)
            {
                // ajax Delete
                jQuery.ajax({
                    url: "/admin/category/"+id,
                    data:{
                        "id" : id,
                        "_token" : token
                    },
                    type: 'DELETE',
                    success: function (response) {
                        if(response.status = "success") {
                            swal({
                                title: "Berhasil !",
                                text: "Data Berhasil Dihapus !!",
                                icon: "success",
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            swal({
                                title: "Gagal !",
                                text: "Data Gagal Dihapus !!",
                                icon: "success",
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function() {
                                location.reload();
                            });
                        }
                    }
                });
            } else {
                return true;
            }
        })
    }
</script>
@endsection
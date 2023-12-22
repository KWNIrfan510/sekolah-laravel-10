@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tags</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-tags"></i> Tags</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.tag.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                @can('tags.create')
                                    <div class="input-group-prepend">
                                        <a href="{{ route('admin.tag.create') }}" class="btn btn-primary" style="padding-top: 10px"><i class="fa fa-plus-circle"></i> Tambah</a>
                                    </div>
                                @endcan
                                <input type="text" name="q" class="form-control" placeholder="Cari Berdasarkan Nama Tag">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" ></i> Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center; width: 6px">No</th>
                                    <th scope="col">Nama Tag</th>
                                    <th scope="col" style="width: 15%; text-align: center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tags as $no => $tag)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no + ($tags->currentPage() - 1) * $tags->perPage() }}</th>
                                        <td>{{ $tag->name }}</td>
                                        <td class="text-center">
                                            @can('tags.edit')
                                                <a href="{{ route('admin.tag.edit', $tag->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>
                                            @endcan

                                            @can('tags.delete')
                                                <button onclick="Delete(this.id)" class="btn btn-sm btn-danger" id={{ $tag->id }}>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{ $tags->links("vendor.pagination.bootstrap-5") }}
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
                    url: "/admin/tag/"+id,
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
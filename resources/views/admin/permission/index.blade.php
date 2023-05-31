@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Permissions</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-key"></i> Permissions</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('Admin.permission.index') }}" method="get">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" name="q" class="form-control" placeholder="cari berdasarkan nama permissions">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thread>
                                <tr>
                                    <th scope="col" style="text-align:center; width:6%">No</th>
                                    <th scope="col">Nama Permission</th>
                                </tr>
                            </thread>
                            <tbody>
                                @foreach ($permissions as $no => $permission)
                                    <tr>
                                        <th scope="row" style="text-align:center">{{ ++$no + ($permissions->currentPage()-1) * $permissions->perPage() }}</th>
                                        <td>{{ $permission->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="text-align:center">
                            {{ $permissions->links("vendor.pagination.bootstrap-5") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
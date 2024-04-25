@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Agenda</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-bell"></i> Edit Agenda</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.event.update', $event->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Judul Agenda</label>
                                <input type="text" name="title" value="{{ old('title', $event->title) }}"
                                    placeholder="Masukkan Judul Agenda"
                                    class="form-control @error('title') is-invalid @enderror">

                                @error('title')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <input type="text" name="location"
                                            value="{{ old('location', $event->location) }}"
                                            placeholder="Masukkan Lokasi Agenda"
                                            class="form-control @error('location') is-invalid @enderror">

                                        @error('location')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" name="date" value="{{ old('date', $event->date) }}"
                                            class="form-control @error('date') is-invalid @enderror">

                                        @error('date')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Isi Agenda</label>
                                <textarea name="content" rows="10" placeholder="Masukkan Konten / Isi Agenda"
                                    class="form-control content @error('content') is-invalid @enderror">{!! old('content', $event->content) !!}</textarea>

                                @error('content')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mr-1 btn-submit"><i class="fa fa-paper-plane"></i>
                                Update</button>
                            <button type="reset" class="btn btn-danger"><i class="fa fa-redo"></i> Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
    <script>
        var editor_config = {
            selector: "textarea.content",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
        }

        tinymce.init(editor_config)
    </script>
@endsection

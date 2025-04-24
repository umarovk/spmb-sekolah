@extends('partials.master')

@section('isisiswa')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!-- /.row -->
                <h1>Data Calon Siswa Baru</h1>

                <button
                    class="btn btn-success"
                    onclick="window.location.href='{{ route('siswa.create') }}'"
                >Input data siswa
                </button>


                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Responsive Hover Table</h3>

                                <div class="card-tools">
                                    <div
                                        class="input-group input-group-sm"
                                        style="width: 150px;"
                                    >
                                        <input
                                            type="text"
                                            name="table_search"
                                            class="form-control float-right"
                                            placeholder="Search"
                                        >

                                        <div class="input-group-append">
                                            <button
                                                type="submit"
                                                class="btn btn-default"
                                            >
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Nama</th>
                                            <th>Jurusan</th>
                                            <th>Agama</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($dtsiswa as $dt) --}}
                                        @forelse ($datasiswa as $dt)
                                            <tr>
                                                {{-- buat looping penomoran --}}
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $dt->namasiswa }}</td>
                                                <td>{{ $dt->jurusan }}</td>
                                                <td>{{ $dt->agama ?? '-' }}</td>
                                                <td>{{ $dt->jeniskelamin }}</td>
                                                <td>Status Bayar</td>
                                                <td>
                                                    <form
                                                        action="{{ route('siswa.destroy', $dt->id) }}"
                                                        method="POST"
                                                        style="display:inline;"
                                                        onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger"
                                                        >Hapus</button>
                                                    </form>
                                                    <a
                                                        href="{{ route('siswa.editdata', $dt->id) }}"
                                                        class="btn btn-primary"
                                                    >Edit</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Post belum Tersedia.
                                            </div>
                                        @endforelse ($dtsiswa as $dt)
                                        {{-- @endforeach --}}
                                    </tbody>
                                </table>
                                {{-- {{ $datasiswa->links() }} --}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
    <!--end::App Main-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        //message with toastr
        @if (session()->has('success'))

            toastr.success('{{ session('success') }}', 'BERHASIL!');
        @elseif (session()->has('error'))

            toastr.error('{{ session('error') }}', 'GAGAL!');
        @endif
    </script>
@endsection

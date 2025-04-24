@extends('partials.master')

@section('editbayar')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Pembayaran</h5>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">Siswa</label>
                            <select class="form-select @error('siswa_id') is-invalid @enderror" id="siswa_id" name="siswa_id" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->id }}" {{ old('siswa_id', $pembayaran->siswa_id) == $s->id ? 'selected' : '' }}>
                                        {{ $s->nis }} - {{ $s->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                            <select class="form-select @error('jenis_pembayaran') is-invalid @enderror" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                <option value="">-- Pilih Jenis Pembayaran --</option>
                                <option value="Pendaftaran" {{ old('jenis_pembayaran', $pembayaran->jenis_pembayaran) == 'Pendaftaran' ? 'selected' : '' }}>Pendaftaran</option>
                                <option value="SPP" {{ old('jenis_pembayaran', $pembayaran->jenis_pembayaran) == 'SPP' ? 'selected' : '' }}>SPP</option>
                                <option value="Seragam" {{ old('jenis_pembayaran', $pembayaran->jenis_pembayaran) == 'Seragam' ? 'selected' : '' }}>Seragam</option>
                                <option value="Kegiatan" {{ old('jenis_pembayaran', $pembayaran->jenis_pembayaran) == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                <option value="Lainnya" {{ old('jenis_pembayaran', $pembayaran->jenis_pembayaran) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $pembayaran->jumlah) }}" required>
                            </div>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control @error('tanggal_pembayaran') is-invalid @enderror" id="tanggal_pembayaran" name="tanggal_pembayaran" value="{{ old('tanggal_pembayaran', $pembayaran->tanggal_pembayaran) }}" required>
                            @error('tanggal_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select @error('metode_pembayaran') is-invalid @enderror" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="Tunai" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                                <option value="Transfer Bank" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="Virtual Account" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'Virtual Account' ? 'selected' : '' }}>Virtual Account</option>
                                <option value="QRIS" {{ old('metode_pembayaran', $pembayaran->metode_pembayaran) == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                            </select>
                            @error('metode_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                            <select class="form-select @error('status_pembayaran') is-invalid @enderror" id="status_pembayaran" name="status_pembayaran" required>
                                <option value="">-- Pilih Status Pembayaran --</option>
                                <option value="Belum Lunas" {{ old('status_pembayaran', $pembayaran->status_pembayaran) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                <option value="Lunas" {{ old('status_pembayaran', $pembayaran->status_pembayaran) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="Pending" {{ old('status_pembayaran', $pembayaran->status_pembayaran) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Gagal" {{ old('status_pembayaran', $pembayaran->status_pembayaran) == 'Gagal' ? 'selected' : '' }}>Gagal</option>
                            </select>
                            @error('status_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $pembayaran->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                            @if ($pembayaran->bukti_pembayaran)
                                <div class="mb-2">
                                    <p>Bukti pembayaran saat ini:</p>
                                    
                                    @php
                                        $extension = pathinfo($pembayaran->bukti_pembayaran, PATHINFO_EXTENSION);
                                    @endphp
                                    
                                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-thumbnail" style="max-height: 200px">
                                    @else
                                        <a href="{{ asset('storage/bukti_pembayaran/' . $pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-file-pdf"></i> Lihat File Bukti Pembayaran
                                        </a>
                                    @endif
                                </div>
                            @endif
                            
                            <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror" id="bukti_pembayaran" name="bukti_pembayaran">
                            <div class="form-text">Format file: JPG, PNG, PDF. Maksimal 2MB. Kosongkan jika tidak ingin mengganti bukti pembayaran.</div>
                            @error('bukti_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Perbarui Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#siswa_id').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Siswa --',
            allowClear: true
        });
    });
</script>
@endsection
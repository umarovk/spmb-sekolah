@extends('partials.master')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/bahan.css') }}"
    >
@endpush

@section('content')
    <div class="bahan-page">
        <div class="container-fluid">

            <div class="bahan-header">
                <div class="bahan-header-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="bahan-header-text">
                    <h1 class="bahan-title">Kelola Bahan Siswa</h1>
                    <p class="bahan-subtitle">{{ $siswa->namasiswa }} — {{ $siswa->jurusan }} ({{ $siswa->nisn ?: 'NISN -' }})</p>
                </div>
                <div class="bahan-header-action">
                    <a
                        href="{{ route('bahan.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>
                </div>
            @endif

            <div class="bahan-card">
                <div class="bahan-card-header">
                    <h3 class="bahan-card-title">
                        <i class="bi bi-check2-square"></i> Checklist Pengambilan Bahan
                    </h3>
                </div>
                <div class="bahan-card-body">
                    <form
                        action="{{ route('bahan.update-checklist', $siswa->id) }}"
                        method="POST"
                    >
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pengambilan (default untuk item baru)</label>
                                <input
                                    type="date"
                                    name="tanggal_pengambilan"
                                    class="form-control"
                                    value="{{ date('Y-m-d') }}"
                                >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Keterangan (opsional)</label>
                                <input
                                    type="text"
                                    name="keterangan"
                                    class="form-control"
                                    placeholder="Misal: ukuran XL, diambil orang tua, dsb."
                                >
                            </div>
                        </div>

                        <div class="b-checklist-grid">
                            @foreach ($items as $item)
                                @php
                                    $isTaken = isset($taken[$item]);
                                    $record = $taken[$item] ?? null;
                                @endphp
                                <label class="b-checklist-item {{ $isTaken ? 'is-taken' : '' }}">
                                    <input
                                        type="checkbox"
                                        name="items[]"
                                        value="{{ $item }}"
                                        {{ $isTaken ? 'checked' : '' }}
                                    >
                                    <span class="b-check-visual">
                                        <i class="bi bi-check-lg"></i>
                                    </span>
                                    <span class="b-check-body">
                                        <span class="b-check-name">{{ $item }}</span>
                                        @if ($isTaken && $record->tanggal_pengambilan)
                                            <span class="b-check-meta">
                                                <i class="bi bi-calendar-check"></i>
                                                Diambil {{ $record->tanggal_pengambilan->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="b-check-meta b-check-meta-belum">
                                                <i class="bi bi-circle"></i> Belum diambil
                                            </span>
                                        @endif
                                        @if ($isTaken && $record->keterangan)
                                            <span class="b-check-note">{{ $record->keterangan }}</span>
                                        @endif
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        <div class="b-checklist-actions">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                id="b-check-all"
                            >
                                <i class="bi bi-check2-all"></i> Centang Semua
                            </button>
                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                id="b-uncheck-all"
                            >
                                <i class="bi bi-square"></i> Hapus Semua Centang
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary ms-auto"
                            >
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const grid = document.querySelector('.b-checklist-grid');
            if (!grid) return;
            const boxes = grid.querySelectorAll('input[type="checkbox"]');
            document.getElementById('b-check-all').addEventListener('click', () => {
                boxes.forEach(b => { b.checked = true; b.closest('.b-checklist-item').classList.add('is-taken'); });
            });
            document.getElementById('b-uncheck-all').addEventListener('click', () => {
                boxes.forEach(b => { b.checked = false; b.closest('.b-checklist-item').classList.remove('is-taken'); });
            });
            boxes.forEach(b => {
                b.addEventListener('change', () => {
                    b.closest('.b-checklist-item').classList.toggle('is-taken', b.checked);
                });
            });
        })();
    </script>
@endsection

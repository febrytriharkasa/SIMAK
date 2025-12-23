@extends('layouts.sbadmin')

@section('title', 'Approval Pendaftaran MI')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Verifikasi Pendaftaran Siswa MI</h4>
    </div>

    {{-- Alert session --}}
    @foreach (['success', 'error', 'info'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} shadow-sm">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    {{-- Tabel --}}
    @if($siswas->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Pendaftaran Menunggu Persetujuan</h6>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th class="text-start">Nama Siswa</th>
                                <th>Tahun Masuk</th>
                                <th>KK</th>
                                <th>Akte</th>
                                <th>Foto Siswa</th>
                                <th>Bukti Pembayaran</th>
                                <th>Status</th>
                                <th style="width:220px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswas as $siswa)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="text-start">
                                        <strong>{{ $siswa->nama }}</strong><br>
                                        <small class="text-muted">
                                            Wali: {{ $siswa->nama_wali }}
                                        </small>
                                    </td>

                                    <td>{{ $siswa->tahun }}</td>

                                    {{-- KK --}}
                                    <td>
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm show-image"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="{{ asset('storage/'.$siswa->kk) }}">
                                            <i class="bi bi-file-earmark-image"></i> Lihat
                                        </button>
                                    </td>

                                    {{-- Akte --}}
                                    <td>
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm show-image"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="{{ asset('storage/'.$siswa->akte) }}">
                                            <i class="bi bi-file-earmark-image"></i> Lihat
                                        </button>
                                    </td>

                                    {{-- Foto Siswa --}}
                                    <td>
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm show-image"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="{{ asset('storage/'.$siswa->foto_siswa) }}">
                                            <i class="bi bi-file-earmark-image"></i> Lihat
                                        </button>
                                    </td>

                                    {{-- Bukti Pembayaran --}}
                                    <td>
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm show-image"
                                                data-bs-toggle="modal"
                                                data-bs-target="#imageModal"
                                                data-img="{{ asset('storage/'.$siswa->bukti_pembayaran) }}">
                                            <i class="bi bi-file-earmark-image"></i> Lihat
                                        </button>
                                    </td>

                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- FORM APPROVE --}}
                                            <form action="{{ route('admin.pendaftaran.mi.approve', $siswa->id) }}"
                                                  method="POST" class="d-flex gap-1">
                                                @csrf
                                                <button class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>

                                            {{-- FORM TOLAK --}}
                                            <form action="{{ route('admin.pendaftaran.mi.reject', $siswa->id) }}"
                                                  method="POST">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" title="Tolak">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center shadow-sm">
            Tidak ada pendaftaran yang menunggu verifikasi.
        </div>
    @endif

</div>

{{-- Modal untuk preview gambar --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img src="" id="modalImage" class="img-fluid w-100" alt="Preview">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const imageButtons = document.querySelectorAll('.show-image');
        const modalImage = document.getElementById('modalImage');

        imageButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const src = this.getAttribute('data-img');
                modalImage.src = src;
            });
        });
    });
</script>
@endpush

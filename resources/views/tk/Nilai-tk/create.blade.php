@extends('layouts.sbadmin')

@section('title', 'Input Nilai Kelas')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Input Nilai Kelas</h5>
                </div>
                <div class="card-body">

                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('nilai-tk.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Kelas --}}
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                       {{-- Pilih Mapel --}}
                        <div class="mb-3">
                            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                            <select name="mapel_id" id="mapel_id" class="form-control" required>
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($mapelList as $m)
                                    <option value="{{ $m->id }}">
                                        {{ $m->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pilih Guru (otomatis terisi setelah pilih mapel) --}}
                        <div class="mb-3" id="guru-wrapper" style="display:none;">
                            <label for="guru_id" class="form-label">Guru</label>
                            <select name="guru_id" id="guru_id" class="form-control" required>
                                <option value="">-- Pilih Guru --</option>
                                {{-- akan diisi pakai JS --}}
                            </select>
                        </div>

                        {{-- Daftar Siswa (muncul via AJAX setelah pilih kelas) --}}
                        <div id="siswa-container" class="mt-4" style="display:none;">
                            <h6>Daftar Siswa</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tugas</th>
                                        <th>UTS</th>
                                        <th>UAS</th>
                                    </tr>
                                </thead>
                                <tbody id="siswa-list">
                                    {{-- akan diisi pakai JS --}}
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success me-2">
                                <i class="bi bi-check-circle"></i> Simpan Semua Nilai
                            </button>
                            <a href="{{ route('nilai-tk.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const siswaData = @json($kelasList->load('siswas')); 
    const mapelData = @json($mapelList->load('guru')); // mapel + daftar guru

    const container = document.getElementById('siswa-container');
    const tbody = document.getElementById('siswa-list');
    const guruWrapper = document.getElementById('guru-wrapper');
    const guruSelect = document.getElementById('guru_id');
    console.log(mapelData);


    // Event pilih kelas → tampil siswa
    document.getElementById('kelas_id').addEventListener('change', function () {
        let kelasId = this.value;
        tbody.innerHTML = '';

        if (kelasId) {
            let kelas = siswaData.find(k => k.id == kelasId);
            if (kelas && kelas.siswas.length > 0) {
                kelas.siswas.forEach(s => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${s.nama}</td>
                            <td>
                                <div class="tugas-wrapper" data-siswa="${s.id}">
                                    <div class="input-group mb-2">
                                        <input type="number" name="nilai[${s.id}][tugas][]" class="form-control" placeholder="Tugas">
                                        <button type="button" class="btn btn-outline-primary btn-sm add-tugas" data-siswa="${s.id}">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td><input type="number" name="nilai[${s.id}][uts]" class="form-control" placeholder="UTS"></td>
                            <td><input type="number" name="nilai[${s.id}][uas]" class="form-control" placeholder="UAS"></td>
                        </tr>
                    `;
                });
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        } else {
            container.style.display = 'none';
        }
    });

    // Event pilih mapel → tampil dropdown guru
    document.getElementById('mapel_id').addEventListener('change', function () {
        let mapelId = this.value;
        guruSelect.innerHTML = '<option value="">-- Pilih Guru --</option>';

        if (mapelId) {
            let mapel = mapelData.find(m => m.id == mapelId);
            if (mapel && mapel.guru.length > 0) {
                mapel.guru.forEach(g => {
                    let opt = document.createElement('option');
                    opt.value = g.id;
                    opt.text = g.nama;
                    guruSelect.appendChild(opt);
                });
                guruWrapper.style.display = 'block';
            } else {
                guruWrapper.style.display = 'none';
            }
        } else {
            guruWrapper.style.display = 'none';
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('add-tugas')) {
            let siswaId = e.target.dataset.siswa;
            let wrapper = document.querySelector(`.tugas-wrapper[data-siswa="${siswaId}"]`);

            let div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');
            div.innerHTML = `
                <input type="number" name="nilai[${siswaId}][tugas][]" class="form-control" placeholder="Tugas">
                <button type="button" class="btn btn-outline-danger btn-sm remove-tugas">-</button>
            `;

            wrapper.appendChild(div);
        }

        // Hapus field tugas
        if (e.target && e.target.classList.contains('remove-tugas')) {
            e.target.parentElement.remove();
        }
    });
</script>

@endsection

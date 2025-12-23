<h3>Halo {{ $siswa->nama }},</h3>

<p>
    Pendaftaran Anda di MI telah
    <strong>{{ $status == 'approved' ? 'disetujui' : 'ditolak' }}</strong>.
</p>

@if($status == 'approved')
    <p>Nomor Induk Siswa (NIS): {{ $siswa->id_tk}}</p>
@endif

<p>Terima kasih telah mendaftar.</p>
<p>Salam,<br>Tim Administrasi MI</p>
<?php

namespace App\Mail;

use App\Models\Siswa_MI;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendaftaranMIStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $siswa;
    public $status;

    public function __construct(Siswa_MI $siswa, $status)
    {
        $this->siswa = $siswa;
        $this->status = $status; // 'approved' atau 'rejected'
    }

    public function build()
    {
        $subject = $this->status == 'approved'
            ? 'Pendaftaran Anda Telah Disetujui'
            : 'Pendaftaran Anda Ditolak';

        return $this->subject($subject)
                    ->view('admin.pendaftaran-mi-approvel.pendaftaran_status');
    }
}

<?php

namespace App\Mail;

use App\Models\Siswa_MI;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AkunOrangtuaApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $siswa;
    public $password;

    public function __construct(Siswa_MI $siswa, $password)
    {
        $this->siswa = $siswa;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Akun Orang Tua SIMAK Telah Aktif')
            ->view('emails.ortu-approved');
    }
}

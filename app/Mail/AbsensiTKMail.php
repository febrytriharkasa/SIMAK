<?php

namespace App\Mail;

use App\Models\AbsensiTK;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbsensiTKMail extends Mailable
{
    use Queueable, SerializesModels;

    public $absensi;

    /**
     * Create a new message instance.
     */
    public function __construct(AbsensiTK $absensi)
    {
        $this->absensi = $absensi;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Informasi Absensi Siswa')
                    ->view('tk.absensi-tk.absensi-email');
    }
}

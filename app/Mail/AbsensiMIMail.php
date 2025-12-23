<?php

namespace App\Mail;

use App\Models\AbsensiMI;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbsensiMIMail extends Mailable
{
    use Queueable, SerializesModels;

    public $absensi;

    /**
     * Create a new message instance.
     */
    public function __construct(AbsensiMI $absensi)
    {
        $this->absensi = $absensi;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Informasi Absensi Siswa')
                    ->view('mi.absensi-mi.absensi-email');
    }
}

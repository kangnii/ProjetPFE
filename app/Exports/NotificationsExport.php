<?php

namespace App\Exports;

use App\Models\WhatsappMessage;
use Maatwebsite\Excel\Concerns\FromCollection;

class NotificationsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = WhatsappMessage::where('status', 'sent')->get();
        return $data;
    }
}

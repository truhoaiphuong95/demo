<?php

namespace App\Http\Controllers\TechKing;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function getIndex()
    {
        $data['care_tickets'] = ticket::where('ticket_status_id', 4)->get();
        $data['severe_tickets'] = ticket::where('ticket_status_id', 2)->get();
        $data['inprocess_tickets'] = ticket::where('ticket_status_id', 2)->get();
        return view('techking/dashboard', $data);
    }
}

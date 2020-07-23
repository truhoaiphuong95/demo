<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Staff;

use Core\Services\TicketServiceContract;
use Core\Services\TicketRelatedService;

class TicketController extends Controller
{
    protected $service;
    protected $relatedService;

    public function __construct(TicketServiceContract $service, TicketRelatedService $related)
    {
        $this->service = $service;  
        $this->relatedService = $related;
    }

    public function getList() { 
        $data['tickets'] = $this->service->getList();
        return view('ticket-list', $data);
    }
    
    public function getChangeStatus($ticket_id, $ticketstatus_id, $price = NULL) {
        $this->service->setStatusId($ticket_id, $ticketstatus_id, $price);
        return redirect()->route('staff.ticket.view.get', ['ticket_id' => $ticket_id]);
    }
    
    public function getView($ticket_id) {
        $data = $this->service->getView($ticket_id);
        return view('ticket-view', $data);
    }

    public function getPrint($ticket_id) {
        $data['ticket'] = $this->service->find($ticket_id);
        return view('ticket-print', $data);
    }

    public function getPrintPos($ticket_id) {
        $data['ticket'] = $this->service->find($ticket_id);
        return view('ticket-printpos', $data);
    }
    
    public function getPrintInternal($ticket_id) {
        $data['ticket'] = $this->service->find($ticket_id);
        return view('ticket-printinternal', $data);
    }
    
    public function getAdd($client_id) {
        $data['ticket_old'] = $this->relatedService->client->find($client_id)->tickets->first();
        $data['client'] = $this->relatedService->client->find($client_id);
        $data['services'] = $this->relatedService->service->all();
        $data['staffs'] = staff::all();
        return view('ticket-add', $data);
    }
    
    public function postAdd(Request $req) {
        $ticket = $this->service->store($req);        
        return redirect()->route('staff.ticket.view.get', ['ticket_id' => $ticket->id]);
    }
    
    public function getUseOld($ticket_id) {
        $data['ticket_old'] = $this->service->find($ticket_id);
        $data['client'] = $data['ticket_old']->client;
        $data['services'] = $this->relatedService->service->all();
        return view('ticket-add', $data);
    }
    
    public function getEdit($ticket_id) {
        $data['ticket'] = $this->service->find($ticket_id);
        return view('ticket-edit', $data);
    }
    
    public function postEdit(Request $req) {
        $this->service->update($req->id, $req);
        return redirect()->route('staff.ticket.view.get', ['ticket_id' => $req->id])->with('success', 'Đã cập nhật thành công!');
    }

}

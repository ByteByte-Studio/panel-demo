<?php

namespace App\Livewire;

use App\Enums\AppointmentStatus;
use App\Models\Appointments;
use App\Models\Client;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts::app')]
class ScheduleAppointment extends Component
{
    public $phone_number;

    public $full_name;

    public $email;

    public $date;

    public $time;

    public $notes;

    public $isExisting = false;

    public $success = false;

    public function mount()
    {
        $this->phone_number = request()->query('phone');
        if ($this->phone_number) {
            $this->checkPhone();
        }
    }

    protected $rules = [
        'phone_number' => 'required|min:10',
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required',
    ];

    public function checkPhone()
    {
        if (strlen($this->phone_number) >= 10) {
            $client = Client::where('phone_number', 'like', "%{$this->phone_number}%")->first();

            if ($client) {
                $this->full_name = $client->full_name;
                $this->email = $client->email;
                $this->isExisting = true;
            } else {
                $this->isExisting = false;
            }
        }
    }

    public function confirmAppointment()
    {
        $this->validate();

        $client = Client::updateOrCreate(
            ['phone_number' => $this->phone_number],
            [
                'full_name' => $this->full_name,
                'email' => $this->email,
            ]
        );

        Appointments::create([
            'appointmentable_id' => $client->id,
            'appointmentable_type' => Client::class,
            'date_time' => Carbon::parse($this->date.' '.$this->time),
            'notes' => $this->notes,
            'status' => AppointmentStatus::Pending,
        ]);

        $this->success = true;
    }

    public function render()
    {
        return view('livewire.schedule-appointment');
    }
}

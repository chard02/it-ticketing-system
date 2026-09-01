<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }
}

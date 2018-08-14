<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use Alert;
use Carbon\Carbon;
use Auth;
use DB;

class ConsulVenController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {
        
            
            return view('consultas.ventas.index);
       
    }
}

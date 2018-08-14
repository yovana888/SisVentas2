<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table='caja';

    protected $primaryKey='idcaja';

    public $timestamps=false;


    protected $fillable =[
    	'fecha',
    	'hora_apertura',
    	'hora_cierre',
    	'monto_cierre',
    	'monto_aper',
    	'idsucursal',
        'estado'
   
        
    ];

    protected $guarded =[

    ];
}

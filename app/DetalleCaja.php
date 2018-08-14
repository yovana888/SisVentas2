<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleCaja extends Model
{
    protected $table='detalle_caja';

    protected $primaryKey='iddetalle_caja';

    public $timestamps=false;


    protected $fillable =[
    	'idcaja',
    	'descripcion',
    	'hora',
    	'monto',
    	'tipo'
        
    ];

    protected $guarded =[

    ];
}

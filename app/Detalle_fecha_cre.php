<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Detalle_fecha_cre extends Model
{
      protected $table='detalle_fecha_cre';

	    protected $primaryKey='iddetalle';

	    public $timestamps=false;


	    protected $fillable =[
	    	'idcredito',
	    	'fecha'
	    ];

	    protected $guarded =[

	    ];
}

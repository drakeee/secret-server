<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecretTable extends Model
{
	//Disable updated_at and created_at timestamps
	public $timestamps = false;
}

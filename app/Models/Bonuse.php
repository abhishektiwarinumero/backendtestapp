<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bonuse extends Model
{
	use HasFactory;

	public function booster()
	{
		return $this->belongsTo(User::class, 'booster_id');
	}

	// public function booster()
	// {
	// 	return $this->belongsTo(User::class);
	// }

	// public function order()
	// {
	// 	return $this->belongsTo(Order::class);
	// }
}

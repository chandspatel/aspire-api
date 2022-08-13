<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LoanRepayments extends Model
{
	use HasFactory;
	public $table = 'loan_repayments';
	protected $fillable = [
		'loan_id',
		'repayment_amount',
		'repayment_date',
		'status'
	];

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format('Y-m-d H:i:s');
	}

	public function getUpdatedAtAttribute($value)
	{
		return Carbon::parse($value)->format('Y-m-d H:i:s');
	}

	public function loans()
	{
		return $this->belongsTo(Loans::class, 'loan_id');
	}
}

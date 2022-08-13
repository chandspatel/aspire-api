<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loans extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'loan_amount',
		'loan_term',
		'status'
	];


	CONST REPAYMENTS_INTERVAL = 7;

	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format('Y-m-d H:i:s');
	}

	public function getUpdatedAtAttribute($value)
	{
		return Carbon::parse($value)->format('Y-m-d H:i:s');
	}

	/**
	 * Get the loan replayments for the loans.
	 */
	public function loanRepayments()
	{
		return $this->hasMany(LoanRepayments::class, 'loan_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function createLoan($fields) {
		
		// insert loans
		$loan = Loans::create([
			'user_id' => auth()->user()->id,
			'loan_amount' => $fields['loan_amount'],
			'loan_term' => $fields['loan_term']
		]);

		if($loan){
			// insert loan repayment 
			$repayment_amount = round($fields['loan_amount'] / $fields['loan_term'],2);
			$loanRepaymentArray = [];
			for ($i=1; $i <= $fields['loan_term']; $i++) {
				$interval = $i*self::REPAYMENTS_INTERVAL;

				$replayment_date = Carbon::now()->addDays($interval)->format('Y-m-d');
				$loanRepaymentArray[] = [
					'loan_id' => $loan->id,
					'repayment_amount' => $repayment_amount,
					'repayment_date' => $replayment_date,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				];
			}

			$loanRepayment = LoanRepayments::insert($loanRepaymentArray);
			if ($loanRepayment){
				return true;
			}
		}
		return false;

	}

	public function approveOrPaidLoans($loan_id, $status){
		$loans = self::where('id', $loan_id)->first();
		if(empty($loans)){
			return false;
		}
		$loans->status = $status;
		$loans->save();
		return $loans;
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Loans;
use App\Models\LoanRepayments;

class LoansController extends Controller
{
	public function createLoan(Request $requests){
		$fields = $requests->validate([
			'loan_amount' => 'required|numeric',
			'loan_term' => 'required|integer'
		]);

		$loans = Loans::createLoan($fields);
		if($loans){
			return response([
				'message' => 'Loan created successfully!',
				'code' => 200
			], 200);
		}
		return response([
			'message' => 'Something went wrong!',
			'code' => 400
		], 200);
	}

	public function getLoans(){

		$loans = Loans::with(['loanRepayments', 'user']);
		if(auth()->user()->user_type == 0){
			$loans = $loans->where('user_id',auth()->user()->id);
		}
		$loans = $loans->get();

		if($loans){
			return response([
				'data' => $loans,
				'code' => 200
			], 200);
		}
		return response([
			'message' => 'Something went wrong!',
			'code' => 400
		], 200);
	}

	public function approveLoans(Request $requests){
		$fields = $requests->validate([
			'loan_id' => 'required|integer'
		]);

		if(auth()->user()->user_type == 0){
			return response([
				'message' => 'Customer can not access this API',
				'code' => 400
			], 200);
		}
		$loans = Loans::approveOrPaidLoans($requests->loan_id, 'approved');
		if($loans){
			return response([
				'data' => $loans,
				'message' => "Loans approved successfully!",
			], 200);
		}

		return response([
			'message' => 'Loans detail not found!',
			'code' => 400
		], 200);

	}

	public function repaymentLoansAmount(Request $requests){
		$fields = $requests->validate([
			'repayment_loan_id' => 'required|integer',
			'repayment_loan_amount' => 'required|integer'
		]);
		$loans = LoanRepayments::with('loans')->where(['id' => $fields['repayment_loan_id'], 'status'=> 'pending'])->first();

		if($loans){
			if($loans->loans->status == 'approved'){
				if($loans->repayment_amount <= $fields['repayment_loan_amount']){
					LoanRepayments::where('id',$fields['repayment_loan_id'])->update(['status' => 'paid']);

					$countPaidStatus = LoanRepayments::where('status','paid')->count();
					if($loans->loans->loan_term == $countPaidStatus){
						Loans::approveOrPaidLoans($loans->loan_id, 'paid');
					}
					return response([
						'message' => 'Loans repayment paid successfully!',
						'code' => 200
					], 200);
				} else {
					return response([
						'message' => 'Loans repayment amount should not be less than scheduled repayment amount :'.$loans->repayment_amount ,
						'code' => 400
					], 200);
				}
			} else {
				return response([
					'message' => 'Loans not approved!',
					'code' => 400
				], 200);
			}
		}
		return response([
			'message' => 'Loans repayment detail not found!',
			'code' => 400
		], 200);

	}
}

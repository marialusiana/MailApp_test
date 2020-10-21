<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Jsonable;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Connote;
use App\Models\Koli;
use App\Models\Location;
use App\Service\Validate;
use App\Service\Response;
use App\Http\Helpers\Paginator;
use DB;
use Illuminate\Support\Facades\Validator;

use App\Exceptions\ApplicationException;

class TransactionController extends Controller
{

    public function index(Request $request){ 
        
        $transaction = Transaction::select('transaction.id','customer.name as customer_name','customer.name as customer_code',
        'transaction.amount as transaction_amount',  'transaction.discount as transaction_discount',  'transaction.additional_field as transaction_additional_field',
        'transaction.state as transaction_state',  'transaction.code as transaction_code',  'transaction.order_id as transaction_order_id',
        'transaction.location_id', 'transaction.organization_id',  'transaction.created_at',  'transaction.updated_at',
        'transaction.payment_type_name as transaction_payment_type_name', 'transaction.cash_amount as transaction_cash_amount',
        'transaction.cash_charge as transaction_cash_charge', 'transaction.customer_origin', 'transaction.customer_destination')
        ->join('customer', 'customer.id', 'transaction.customer_origin')
        ->get();

        $transaction = $transaction->map(function ($item, $key) {
            $item['customer_attribute'] =  Customer::select('customer.name_sales', 'customer.TOP', 'customer.jenis_pelanggan')
                ->where('id', $item->customer_origin)
                ->get();

            $item['connote'] = Connote::select('connote.*')
                ->where('transaction_id', $item->id)
                ->get();

            $item['origin_data'] = Customer::select('customer.*')
                ->where('id', $item->customer_origin)
                ->get();

            $item['destination_data'] = Customer::select('customer.*')
                ->where('id', $item->customer_destination)
                ->get();

            $item['koli_data'] = Koli::select('koli.*')
                ->where('connote_id', $item->connote_id)
                ->get();

            $item['custom_field'] = Transaction::select('transaction.catatan_tambahan')
                ->where('id', $item->id)
                ->get();

            $item['currentLocation'] = Location::select('location.*')
                ->where('id', $item->location_id)
                ->get();

            $item['custom_field'] = Transaction::select('transaction.catatan_tambahan')
                ->where('id', $item->id)
                ->get();

            $item['currentLocation'] = Location::select('location.*')
                ->where('id', $item->location_id)
                ->get();
            return $item;
        });

        $page = $request->page ? $request->page : 1 ;
        $perPage = $request->query('limit')?? 10;
        $all_transaction = collect($transaction);
        $transaction_new = new Paginator($all_transaction->forPage($page, $perPage), $all_transaction->count(), $perPage, $page, [
            'path' => url("api/package")
        ]); 
        return Response::success($transaction_new);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'amount'            => 'required|integer',
            'discount'          => 'integer',
            'additional_field'  => 'min:10|max:255',
            'payment_type'      => 'required|integer',
            'state'             => 'required|integer',
            'code'              => 'required|integer',
            'order_id'          => 'required|integer',
            'organization_id'   => 'required|integer',
            'location_id'       => 'required|integer',
            'payment_type_name' => 'required|min:3|max:100|string',
            'cash_amount'       => 'required|integer',
            'cash_charge'       => 'required|integer',
            'customer_origin'   => 'required|integer',
            'customer_destination' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $response = array('response' => '', 'success'=>false);
            $response['response'] = $validator->messages();
            return $response;
        }else{
        //process the request
            DB::beginTransaction();
            try {  
                // create transaction
                $transaction = Transaction::create([
                    'amount'            => $request->amount,
                    'discount'          => $request->discount,
                    'additional_field'  => $request->additional_field,
                    'payment_type'      => $request->payment_type,
                    'state'             => $request->state,
                    'code'              => $request->code,
                    'order_id'          => $request->order_id,
                    'organization_id'   => $request->organization_id,
                    'location_id'       => $request->location_id,
                    'payment_type_name' => $request->payment_type_name,
                    'cash_amount'       => $request->cash_amount,
                    'cash_charge'       => $request->cash_charge,
                    'customer_origin'   => $request->customer_origin,
                    'customer_destination' => $request->customer_destination,
                    'catatan_tambahan'     => $request->catatan_tambahan,
                ]);

                DB::commit();
                return Response::success($transaction);

            } catch (Exception $e) {
                DB::rollBack();
                throw new ApplicationException("transaction.failure_save_transaction");
            }
        }
        return $response;
    }

    public function show($id)
    { 
        $transaction = Transaction::select('transaction.id','customer.name as customer_name','customer.name as customer_code',
        'transaction.amount as transaction_amount',  'transaction.discount as transaction_discount',  'transaction.additional_field as transaction_additional_field',
        'transaction.state as transaction_state',  'transaction.code as transaction_code',  'transaction.order_id as transaction_order_id',
        'transaction.location_id', 'transaction.organization_id',  'transaction.created_at',  'transaction.updated_at',
        'transaction.payment_type_name as transaction_payment_type_name', 'transaction.cash_amount as transaction_cash_amount',
        'transaction.cash_charge as transaction_cash_charge', 'transaction.customer_origin', 'transaction.customer_destination')
        ->join('customer', 'customer.id', 'transaction.customer_origin')
        ->where('transaction.id', $id)
        ->get();

        $transaction = $transaction->map(function ($item, $key) {
            $item['customer_attribute'] =  Customer::select('customer.name_sales', 'customer.TOP', 'customer.jenis_pelanggan')
                ->where('id', $item->customer_origin)
                ->get();

            $item['connote'] = Connote::select('connote.*')
                ->where('transaction_id', $item->id)
                ->get();

            $item['connote_id'] = $item['connote'][$key]['id'];

            $item['origin_data'] = Customer::select('customer.*')
                ->where('id', $item->customer_origin)
                ->get();

            $item['destination_data'] = Customer::select('customer.*')
                ->where('id', $item->customer_destination)
                ->get();

            $item['koli_data'] = Koli::select('koli.*')
                ->where('connote_id', $item->connote_id)
                ->get();

            $item['custom_field'] = Transaction::select('transaction.catatan_tambahan')
                ->where('id', $item->id)
                ->get();

            $item['currentLocation'] = Location::select('location.*')
                ->where('id', $item->location_id)
                ->get();

            $item['custom_field'] = Transaction::select('transaction.catatan_tambahan')
                ->where('id', $item->id)
                ->get();

            $item['currentLocation'] = Location::select('location.*')
                ->where('id', $item->location_id)
                ->get();
            return $item;
        });
    
        return Response::success($transaction);

    }

    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), 
        [
            'amount'            => 'required|integer',
            'discount'          => 'integer',
            'additional_field'  => 'min:10|max:255',
            'payment_type'      => 'required|integer',
            'state'             => 'required|integer',
            'code'              => 'required|integer',
            'order_id'          => 'required|integer',
            'organization_id'   => 'required|integer',
            'location_id'       => 'required|integer',
            'payment_type_name' => 'required|min:3|max:100|string',
            'cash_amount'       => 'required|integer',
            'cash_charge'       => 'required|integer',
            'customer_origin'   => 'required|integer',
            'customer_destination' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $response = array('response' => '', 'success'=>false);
            $response['response'] = $validator->messages();
            return $response;
        }else{
   

            DB::beginTransaction();
            try {
                $transaction = Transaction::where('id',$id)->first();

                $transaction  = $transaction->update([
                    'amount'            => $request->amount,
                    'discount'          => $request->discount,
                    'additional_field'  => $request->additional_field,
                    'payment_type'      => $request->payment_type,
                    'state'             => $request->state,
                    'code'              => $request->code,
                    'order_id'          => $request->order_id,
                    'organization_id'   => $request->organization_id,
                    'location_id'       => $request->location_id,
                    'payment_type_name' => $request->payment_type_name,
                    'cash_amount'       => $request->cash_amount,
                    'cash_charge'       => $request->cash_charge,
                    'customer_origin'   => $request->customer_origin,
                    'customer_destination' => $request->customer_destination,
                    'catatan_tambahan'     => $request->catatan_tambahan,
                ]); 

                DB::commit();
                return Response::success($transaction);   
            } catch (Exception $e) {
                DB::rollBack();
                throw new ApplicationException("transaction.failure_update_transaction", ['id' => $id]);
            }

        }

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), 
        [
            'amount'            => 'required|integer',
            'discount'          => 'integer',
          
        ]);

        if ($validator->fails()) {
            $response = array('response' => '', 'success'=>false);
            $response['response'] = $validator->messages();
            return $response;
        }else{
            
            DB::beginTransaction();
            try {
                $transaction = Transaction::where('id',$id)->first();

                $transaction  = $transaction->update([
                    'amount'            => $request->amount,
                    'discount'          => $request->discount,
                ]); 

                DB::commit();
                return Response::success($transaction);   
            } catch (Exception $e) {
                DB::rollBack();
                throw new ApplicationException("transaction.failure_update_transaction", ['id' => $id]);
            }
        } 
    }

    public function delete($id)
    {    
        $transaction = Transaction::where('id',$id)->first();
        //jika ada transaction delete
        if($transaction){
            $transaction = $transaction->delete();
        }

        return Response::success(['id' => $id]);

    }

}
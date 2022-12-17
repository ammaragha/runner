<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\ChangeStatusRequest;
use App\Http\Requests\Order\FindRunnerRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\User\UserResource;
use App\Services\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private OrdersService $ordersService
    ) {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        try {
            $inputs = $request->all();
            $inputs['user_id'] = Auth::user()->id;
            $order = $this->ordersService->create($inputs);
            return $this->createdSuccessfully("Order saved successfully", new OrderResource($order));
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * find runner from order data
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findRunner(FindRunnerRequest $request)
    {
        try {
            $inputs = $request->all();
            $runners = $this->ordersService->findRunner($inputs);
            $metaData = [
                "count" => $runners->toArray()['total'],
                "totalPages" => $runners->toArray()['last_page']
            ];
            return $this->successWithMetaData("Runners Retrived", UserResource::collection($runners), $metaData);
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    /**
     * get recent orders
     * 
     * @param int $limit
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recent(int $limit, Request $request)
    {
        try {
            $limit = $limit >= 20 || $limit <= 1 ? 20 : $limit;
            $inputs = $request->all();
            $user = Auth::user();
            $orders = $this->ordersService->recent($limit, $user->role, $user->id, $inputs);
            return $this->success("orders Retrived", OrderResource::collection($orders));
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    /**
     * Change status of order
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(int $id, ChangeStatusRequest $request)
    {
        try {
            $status = $request->input('status');
            $inputs = $request->all();
            $changed = $this->ordersService->changeStatus($id, $status, $inputs);
            return $this->bool($changed, "Status Changed", "Status not able to change");
        } catch (\Exception $e) {
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\FindRunnerRequest;
use App\Http\Resources\User\UserResource;
use App\Services\OrdersService;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
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
            return $this->successWithMetaData("Runners Retrived",UserResource::collection($runners),$metaData);
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }
}

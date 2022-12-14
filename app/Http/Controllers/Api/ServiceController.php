<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRequest;
use App\Http\Resources\Service\ServicePaginationResource;
use App\Http\Resources\Service\ServiceResource;
use App\Services\ServicesService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ServicesService $servicesService
    ) {
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $services = $this->servicesService->all();
            return $this->success("all services", ServiceResource::collection($services));
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    /**
     * Display a lisiting ofr the resource Paginated.
     * 
     * @return \Illuminate\Http\Response
     */
    public function pagination(string $field = "id", string $type = "desc", int $perPage, Request $request)
    {
        try {
            $search = $request->input('search');
            if ($search) {
                $services = $this->servicesService->search('name', $search, $field, $type)->paginate($perPage);
            } else {
                $services = $this->servicesService->pagination($perPage, $field, $type);
            }
            $metaData = [
                "count" => $services->toArray()['total'],
                "totalPages" => $services->toArray()['last_page']
            ];
            return $this->successWithMetaData('Services', ServiceResource::collection($services), $metaData);
        } catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        // $data = $request->only('name');
        // $stored = $this->servicesService->create($data);
        // if ($stored)
        //     return $this->succWithData(new ServiceResource($stored), 'new category has been added');
        // else
        //     return $this->serverErr("something went wrong");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $category = $this->servicesService->read($id);
        // if ($category)
        //     return $this->succWithData(new ServiceResource($category));
        // else
        //     return $this->badRequest("cant bring that category, check id");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        // $inputs = $request->only('name');
        // $updated = $this->servicesService->update($id,$inputs);
        // if ($updated)
        //     return $this->succMsg("category updated");
        // else
        //     return $this->badRequest("cant  update that category, check id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $deleted = $this->servicesService->delete($id);
        // if ($deleted)
        //     return $this->succMsg("category deleted");
        // else
        //     return $this->badRequest("cant delete that category, check id");
    }
}

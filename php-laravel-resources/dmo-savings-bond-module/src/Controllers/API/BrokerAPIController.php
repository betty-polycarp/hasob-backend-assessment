<?php

namespace DMO\SavingsBond\Controllers\API;

use DMO\SavingsBond\Events\BrokerCreated;
use DMO\SavingsBond\Events\BrokerDeleted;
use DMO\SavingsBond\Events\BrokerUpdated;
use DMO\SavingsBond\Models\Broker;
use DMO\SavingsBond\Requests\API\CreateBrokerAPIRequest;
use DMO\SavingsBond\Requests\API\UpdateBrokerAPIRequest;
use Hasob\FoundationCore\Controllers\BaseController as AppBaseController;
use Hasob\FoundationCore\Models\Organization;
use Hasob\FoundationCore\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class BrokerController
 */
class BrokerAPIController extends AppBaseController
{
    use ApiResponder;

    /**
     * Display a listing of the Broker.
     * GET|HEAD /brokers
     *
     * @return Response
     */
    public function index(Request $request, Organization $organization)
    {
        $query = Broker::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        if ($organization != null) {
            $query->where('organization_id', $organization->id);
        }

        $brokers = $this->showAll($query->get());

        return $this->sendResponse($brokers->toArray(), 'Brokers retrieved successfully');
    }

    /**
     * Store a newly created Broker in storage.
     * POST /brokers
     *
     *
     * @return Response
     */
    public function store(CreateBrokerAPIRequest $request, Organization $organization)
    {
        $input = $request->all();

        /** @var Broker $broker */
        $broker = Broker::create($input);

        BrokerCreated::dispatch($broker);

        return $this->sendResponse($broker->toArray(), 'Broker saved successfully');
    }

    /**
     * Display the specified Broker.
     * GET|HEAD /brokers/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Organization $organization)
    {
        /** @var Broker $broker */
        $broker = Broker::find($id);

        if (empty($broker)) {
            return $this->sendError('Broker not found');
        }

        return $this->sendResponse($broker->toArray(), 'Broker retrieved successfully');
    }

    /**
     * Update the specified Broker in storage.
     * PUT/PATCH /brokers/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateBrokerAPIRequest $request, Organization $organization)
    {
        /** @var Broker $broker */
        $broker = Broker::find($id);

        if (empty($broker)) {
            return $this->sendError('Broker not found');
        }

        $broker->fill($request->all());
        $broker->save();

        BrokerUpdated::dispatch($broker);

        return $this->sendResponse($broker->toArray(), 'Broker updated successfully');
    }

    /**
     * Remove the specified Broker from storage.
     * DELETE /brokers/{id}
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id, Organization $organization)
    {
        /** @var Broker $broker */
        $broker = Broker::find($id);

        if (empty($broker)) {
            return $this->sendError('Broker not found');
        }

        $broker->delete();
        BrokerDeleted::dispatch($broker);

        return $this->sendSuccess('Broker deleted successfully');
    }
}

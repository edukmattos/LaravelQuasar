<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Api\V1\Repositories\ClientRepository;
use App\Api\V1\Validators\ClientValidator;
use App\Api\V1\Transformers\ClientTransformer;

/**
 * Class ClientsController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientsController extends Controller
{
    use Helpers;
    
    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;

    /**
     * @var ClientTransformer
     */
    protected $transformer;

    /**
     * ClientsController constructor.
     *
     * @param ClientRepository $repository
     * @param ClientValidator $validator
     */
    public function __construct(ClientRepository $repository, ClientValidator $validator, ClientTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->transformer  = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $clients = $this->repository
            ->with('client_type', 'client_status', 'client_locations')
            ->all();

        if (request()->wantsJson()) {
            return $this->response->collection($clients, new ClientTransformer);
        }
        
        return view('clients.index', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        try {
            #Cliente Ativo
            $request['client_status_id'] = 1;

            if (strlen($request['einssa'])==11)
            {
                $request['client_type_id'] = 1;
            }
            else
            {
                $request['client_type_id'] = 2;
            }

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            
            $client = $this->repository->create($request->all());
            
            $client = $this->repository->find($client->id);

            if ($request->wantsJson()) {
                return $this->response->item($client, new ClientTransformer);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => '422 Unprocessable Entity',
                    'errors' => $e->getMessageBag(),
                    'status_code' => 422
                ], 422);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->repository->find($id);

        if ($request->wantsJson()) {
            return $this->response->item($client, new ClientTransformer);
        }

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = $this->repository->find($id);

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $client = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Client updated.',
                'data'    => $client->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Client deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Client deleted.');
    }
}

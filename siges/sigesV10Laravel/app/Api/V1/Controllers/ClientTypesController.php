<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Api\V1\Validators\ClientTypeValidator;
use App\Http\Requests\ClientTypeCreateRequest;
use App\Http\Requests\ClientTypeUpdateRequest;
use App\Api\V1\Repositories\ClientTypeRepository;
use App\Api\V1\Transformers\ClientTypeTransformer;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ClientTypesController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientTypesController extends Controller
{
    use Helpers;
    
    /**
     * @var ClientTypeRepository
     */
    protected $repository;

    /**
     * @var ClientTypeValidator
     */
    protected $validator;

    /**
     * ClientTypesController constructor.
     *
     * @param ClientTypeRepository $repository
     * @param ClientTypeValidator $validator
     */
    public function __construct(ClientTypeRepository $repository, ClientTypeValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $client_types = $this->repository->all();

        if (request()->wantsJson()) {
            return $this->response->collection($client_types, new ClientTypeTransformer);
        }

        return view('client_types.index', compact('client_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClientTypeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $client_type = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientType created.',
                'data'    => $client_type->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client_type = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $client_type,
            ]);
        }

        return view('client_types.show', compact('client_type'));
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
        $client_type = $this->repository->find($id);

        return view('client_types.edit', compact('client_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientTypeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $client_type = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientType updated.',
                'data'    => $client_type->toArray(),
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
                'message' => 'ClientType deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ClientType deleted.');
    }
}

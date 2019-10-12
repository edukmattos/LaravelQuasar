<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Api\V1\Validators\ClientStatusValidator;
use App\Http\Requests\ClientStatusCreateRequest;
use App\Http\Requests\ClientStatusUpdateRequest;
use App\Api\V1\Repositories\ClientStatusRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Api\V1\Transformers\ClientStatusTransformer;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class client_statusesController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class client_statusesController extends Controller
{
    use Helpers;
    
    /**
     * @var ClientStatusRepository
     */
    protected $repository;

    /**
     * @var ClientStatusValidator
     */
    protected $validator;

    /**
     * client_statusesController constructor.
     *
     * @param ClientStatusRepository $repository
     * @param ClientStatusValidator $validator
     */
    public function __construct(ClientStatusRepository $repository, ClientStatusValidator $validator)
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
        $client_statuses = $this->repository->all();

        if (request()->wantsJson()) {
            return $this->response->collection($client_statuses, new ClientStatusTransformer);
        }

        return view('client_statuses.index', compact('client_statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientStatusCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClientStatusCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $client_status = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientStatus created.',
                'data'    => $client_status->toArray(),
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
        $client_status = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $client_status,
            ]);
        }

        return view('client_statuses.show', compact('client_status'));
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
        $client_status = $this->repository->find($id);

        return view('client_statuses.edit', compact('client_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientStatusUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientStatusUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $client_status = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientStatus updated.',
                'data'    => $client_status->toArray(),
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
                'message' => 'ClientStatus deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ClientStatus deleted.');
    }
}

<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ClientStatusCreateRequest;
use App\Http\Requests\ClientStatusUpdateRequest;
use App\Api\V1\Repositories\ClientStatusRepository;
use App\Api\V1\Validators\ClientStatusValidator;

/**
 * Class ClientStatusesController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientStatusesController extends Controller
{
    /**
     * @var ClientStatusRepository
     */
    protected $repository;

    /**
     * @var ClientStatusValidator
     */
    protected $validator;

    /**
     * ClientStatusesController constructor.
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
        $clientStatuses = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientStatuses,
            ]);
        }

        return view('clientStatuses.index', compact('clientStatuses'));
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

            $clientStatus = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientStatus created.',
                'data'    => $clientStatus->toArray(),
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
        $clientStatus = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientStatus,
            ]);
        }

        return view('clientStatuses.show', compact('clientStatus'));
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
        $clientStatus = $this->repository->find($id);

        return view('clientStatuses.edit', compact('clientStatus'));
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

            $clientStatus = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientStatus updated.',
                'data'    => $clientStatus->toArray(),
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

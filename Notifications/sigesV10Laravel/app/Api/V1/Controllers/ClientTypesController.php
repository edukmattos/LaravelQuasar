<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ClientTypeCreateRequest;
use App\Http\Requests\ClientTypeUpdateRequest;
use App\Api\V1\Repositories\ClientTypeRepository;
use App\Api\V1\Validators\ClientTypeValidator;

/**
 * Class ClientTypesController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientTypesController extends Controller
{
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
        $clientTypes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientTypes,
            ]);
        }

        return view('clientTypes.index', compact('clientTypes'));
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

            $clientType = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientType created.',
                'data'    => $clientType->toArray(),
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
        $clientType = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientType,
            ]);
        }

        return view('clientTypes.show', compact('clientType'));
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
        $clientType = $this->repository->find($id);

        return view('clientTypes.edit', compact('clientType'));
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

            $clientType = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientType updated.',
                'data'    => $clientType->toArray(),
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TenantConnectionCreateRequest;
use App\Http\Requests\TenantConnectionUpdateRequest;
use App\Repositories\TenantConnectionRepository;
use App\Validators\TenantConnectionValidator;

/**
 * Class TenantConnectionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TenantConnectionsController extends Controller
{
    /**
     * @var TenantConnectionRepository
     */
    protected $repository;

    /**
     * @var TenantConnectionValidator
     */
    protected $validator;

    /**
     * TenantConnectionsController constructor.
     *
     * @param TenantConnectionRepository $repository
     * @param TenantConnectionValidator $validator
     */
    public function __construct(TenantConnectionRepository $repository, TenantConnectionValidator $validator)
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
        $tenantConnections = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tenantConnections,
            ]);
        }

        return view('tenantConnections.index', compact('tenantConnections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TenantConnectionCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TenantConnectionCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tenantConnection = $this->repository->create($request->all());

            $response = [
                'message' => 'TenantConnection created.',
                'data'    => $tenantConnection->toArray(),
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
        $tenantConnection = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $tenantConnection,
            ]);
        }

        return view('tenantConnections.show', compact('tenantConnection'));
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
        $tenantConnection = $this->repository->find($id);

        return view('tenantConnections.edit', compact('tenantConnection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TenantConnectionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TenantConnectionUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tenantConnection = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TenantConnection updated.',
                'data'    => $tenantConnection->toArray(),
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
                'message' => 'TenantConnection deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TenantConnection deleted.');
    }
}

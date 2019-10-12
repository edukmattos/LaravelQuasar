<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ClientAddressCreateRequest;
use App\Http\Requests\ClientAddressUpdateRequest;
use App\Api\V1\Repositories\ClientAddressRepository;
use App\Api\V1\Validators\ClientAddressValidator;

/**
 * Class ClientAddressesController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientAddressesController extends Controller
{
    /**
     * @var ClientAddressRepository
     */
    protected $repository;

    /**
     * @var ClientAddressValidator
     */
    protected $validator;

    /**
     * ClientAddressesController constructor.
     *
     * @param ClientAddressRepository $repository
     * @param ClientAddressValidator $validator
     */
    public function __construct(ClientAddressRepository $repository, ClientAddressValidator $validator)
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
        $clientAddresses = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientAddresses,
            ]);
        }

        return view('clientAddresses.index', compact('clientAddresses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientAddressCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClientAddressCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $clientAddress = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientAddress created.',
                'data'    => $clientAddress->toArray(),
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
        $clientAddress = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientAddress,
            ]);
        }

        return view('clientAddresses.show', compact('clientAddress'));
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
        $clientAddress = $this->repository->find($id);

        return view('clientAddresses.edit', compact('clientAddress'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientAddressUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientAddressUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $clientAddress = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientAddress updated.',
                'data'    => $clientAddress->toArray(),
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
                'message' => 'ClientAddress deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ClientAddress deleted.');
    }
}

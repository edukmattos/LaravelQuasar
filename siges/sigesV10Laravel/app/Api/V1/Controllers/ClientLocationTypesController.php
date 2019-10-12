<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Api\V1\Validators\ClientLocationTypeValidator;
use App\Http\Requests\ClientLocationTypeCreateRequest;
use App\Http\Requests\ClientLocationTypeUpdateRequest;
use App\Api\V1\Repositories\ClientLocationTypeRepository;
use App\Api\V1\Transformers\ClientLocationTypeTransformer;

/**
 * Class ClientLocationTypesController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientLocationTypesController extends Controller
{
    use Helpers;
    
    /**
     * @var ClientLocationTypeRepository
     */
    protected $repository;

    /**
     * @var ClientLocationTypeValidator
     */
    protected $validator;

    /**
     * ClientLocationTypesController constructor.
     *
     * @param ClientLocationTypeRepository $repository
     * @param ClientLocationTypeValidator $validator
     */
    public function __construct(ClientLocationTypeRepository $repository, ClientLocationTypeValidator $validator)
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
        $clientLocationTypes = $this->repository->all();

        if (request()->wantsJson()) {
            return $this->response->collection($clientLocationTypes, new ClientLocationTypeTransformer);
        }

        return view('clientLocationTypes.index', compact('clientLocationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientLocationTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClientLocationTypeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $clientLocationType = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientLocationType created.',
                'data'    => $clientLocationType->toArray(),
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
        $clientLocationType = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientLocationType,
            ]);
        }

        return view('clientLocationTypes.show', compact('clientLocationType'));
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
        $clientLocationType = $this->repository->find($id);

        return view('clientLocationTypes.edit', compact('clientLocationType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientLocationTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientLocationTypeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $clientLocationType = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientLocationType updated.',
                'data'    => $clientLocationType->toArray(),
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
                'message' => 'ClientLocationType deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ClientLocationType deleted.');
    }
}

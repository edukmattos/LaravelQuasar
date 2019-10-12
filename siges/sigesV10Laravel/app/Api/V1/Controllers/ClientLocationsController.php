<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Api\V1\Validators\ClientLocationValidator;
use App\Http\Requests\ClientLocationCreateRequest;
use App\Http\Requests\ClientLocationUpdateRequest;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Api\V1\Repositories\ClientLocationRepository;
use App\Api\V1\Transformers\ClientLocationTransformer;

/**
 * Class ClientLocationsController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientLocationsController extends Controller
{
    use Helpers;
    
    /**
     * @var ClientLocationRepository
     */
    protected $repository;

    /**
     * @var ClientLocationValidator
     */
    protected $validator;

    /**
     * ClientLocationsController constructor.
     *
     * @param ClientLocationRepository $repository
     * @param ClientLocationValidator $validator
     */
    public function __construct(ClientLocationRepository $repository, ClientLocationValidator $validator)
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
        $clientLocations = $this->repository->all();

        if (request()->wantsJson()) {
            return $this->response->collection($clientLocations, new ClientLocationTransformer);
        }

        return view('clientLocations.index', compact('clientLocations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientLocationCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClientLocationCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $clientLocation = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientLocation created.',
                'data'    => $clientLocation->toArray(),
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
        $clientLocation = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientLocation,
            ]);
        }

        return view('clientLocations.show', compact('clientLocation'));
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
        $clientLocation = $this->repository->find($id);

        return view('clientLocations.edit', compact('clientLocation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientLocationUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientLocationUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $clientLocation = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientLocation updated.',
                'data'    => $clientLocation->toArray(),
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
                'message' => 'ClientLocation deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ClientLocation deleted.');
    }
}

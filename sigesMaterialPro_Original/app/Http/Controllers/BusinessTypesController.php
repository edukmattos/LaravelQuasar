<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BusinessTypeCreateRequest;
use App\Http\Requests\BusinessTypeUpdateRequest;
use App\Repositories\BusinessTypeRepository;
use App\Validators\BusinessTypeValidator;

/**
 * Class BusinessTypesController.
 *
 * @package namespace App\Http\Controllers;
 */
class BusinessTypesController extends Controller
{
    /**
     * @var BusinessTypeRepository
     */
    protected $repository;

    /**
     * @var BusinessTypeValidator
     */
    protected $validator;

    /**
     * BusinessTypesController constructor.
     *
     * @param BusinessTypeRepository $repository
     * @param BusinessTypeValidator $validator
     */
    public function __construct(BusinessTypeRepository $repository, BusinessTypeValidator $validator)
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
        $businessTypes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $businessTypes,
            ]);
        }

        return view('businessTypes.index', compact('businessTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BusinessTypeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BusinessTypeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $businessType = $this->repository->create($request->all());

            $response = [
                'message' => 'BusinessType created.',
                'data'    => $businessType->toArray(),
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
        $businessType = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $businessType,
            ]);
        }

        return view('businessTypes.show', compact('businessType'));
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
        $businessType = $this->repository->find($id);

        return view('businessTypes.edit', compact('businessType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BusinessTypeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BusinessTypeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $businessType = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BusinessType updated.',
                'data'    => $businessType->toArray(),
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
                'message' => 'BusinessType deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BusinessType deleted.');
    }
}

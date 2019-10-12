<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MaterialUnitCreateRequest;
use App\Http\Requests\MaterialUnitUpdateRequest;
use App\Repositories\MaterialUnitRepository;
use App\Validators\MaterialUnitValidator;

/**
 * Class MaterialUnitsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MaterialUnitsController extends Controller
{
    /**
     * @var MaterialUnitRepository
     */
    protected $repository;

    /**
     * @var MaterialUnitValidator
     */
    protected $validator;

    /**
     * MaterialUnitsController constructor.
     *
     * @param MaterialUnitRepository $repository
     * @param MaterialUnitValidator $validator
     */
    public function __construct(MaterialUnitRepository $repository, MaterialUnitValidator $validator)
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
        $materialUnits = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $materialUnits,
            ]);
        }

        return view('materialUnits.index', compact('materialUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MaterialUnitCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MaterialUnitCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $materialUnit = $this->repository->create($request->all());

            $response = [
                'message' => 'MaterialUnit created.',
                'data'    => $materialUnit->toArray(),
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
        $materialUnit = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $materialUnit,
            ]);
        }

        return view('materialUnits.show', compact('materialUnit'));
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
        $materialUnit = $this->repository->find($id);

        return view('materialUnits.edit', compact('materialUnit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MaterialUnitUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MaterialUnitUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $materialUnit = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MaterialUnit updated.',
                'data'    => $materialUnit->toArray(),
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
                'message' => 'MaterialUnit deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MaterialUnit deleted.');
    }
}

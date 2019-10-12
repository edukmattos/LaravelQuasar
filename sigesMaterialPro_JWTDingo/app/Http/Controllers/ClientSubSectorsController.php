<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ClientSubSectorCreateRequest;
use App\Http\Requests\ClientSubSectorUpdateRequest;
use App\Repositories\ClientSubSectorRepository;
use App\Validators\ClientSubSectorValidator;

/**
 * Class ClientSubSectorsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ClientSubSectorsController extends Controller
{
    /**
     * @var ClientSubSectorRepository
     */
    protected $repository;

    /**
     * @var ClientSubSectorValidator
     */
    protected $validator;

    /**
     * ClientSubSectorsController constructor.
     *
     * @param ClientSubSectorRepository $repository
     * @param ClientSubSectorValidator $validator
     */
    public function __construct(ClientSubSectorRepository $repository, ClientSubSectorValidator $validator)
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
        $clientSubSectors = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientSubSectors,
            ]);
        }

        return view('clientSubSectors.index', compact('clientSubSectors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientSubSectorCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClientSubSectorCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $clientSubSector = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientSubSector created.',
                'data'    => $clientSubSector->toArray(),
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
        $clientSubSector = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientSubSector,
            ]);
        }

        return view('clientSubSectors.show', compact('clientSubSector'));
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
        $clientSubSector = $this->repository->find($id);

        return view('clientSubSectors.edit', compact('clientSubSector'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientSubSectorUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientSubSectorUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $clientSubSector = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientSubSector updated.',
                'data'    => $clientSubSector->toArray(),
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
                'message' => 'ClientSubSector deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ClientSubSector deleted.');
    }
}

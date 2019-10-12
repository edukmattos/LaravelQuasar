<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ClientSectorCreateRequest;
use App\Http\Requests\ClientSectorUpdateRequest;
use App\Api\V1\Repositories\ClientSectorRepository;
use App\Api\V1\Validators\ClientSectorValidator;

/**
 * Class ClientSectorsController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class ClientSectorsController extends Controller
{
    /**
     * @var ClientSectorRepository
     */
    protected $repository;

    /**
     * @var ClientSectorValidator
     */
    protected $validator;

    /**
     * ClientSectorsController constructor.
     *
     * @param ClientSectorRepository $repository
     * @param ClientSectorValidator $validator
     */
    public function __construct(ClientSectorRepository $repository, ClientSectorValidator $validator)
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
        $clientSectors = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientSectors,
            ]);
        }

        return view('clientSectors.index', compact('clientSectors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientSectorCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClientSectorCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $clientSector = $this->repository->create($request->all());

            $response = [
                'message' => 'ClientSector created.',
                'data'    => $clientSector->toArray(),
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
        $clientSector = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $clientSector,
            ]);
        }

        return view('clientSectors.show', compact('clientSector'));
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
        $clientSector = $this->repository->find($id);

        return view('clientSectors.edit', compact('clientSector'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientSectorUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClientSectorUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $clientSector = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClientSector updated.',
                'data'    => $clientSector->toArray(),
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
                'message' => 'ClientSector deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ClientSector deleted.');
    }
}

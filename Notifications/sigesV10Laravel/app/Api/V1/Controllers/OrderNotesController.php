<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

#use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OrderNoteCreateRequest;
use App\Http\Requests\OrderNoteUpdateRequest;
use App\Api\V1\Repositories\OrderNoteRepository;
use App\Api\V1\Validators\OrderNoteValidator;
use App\Api\V1\Transformers\OrderNoteTransformer;
use Dingo\Api\Routing\Helpers;

/**
 * Class OrderNotesController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class OrderNotesController extends Controller
{
    use Helpers;
    
    /**
     * @var OrderNoteRepository
     */
    protected $repository;

    /**
     * @var OrderNoteValidator
     */
    protected $validator;

    /**
     * OrderNotesController constructor.
     *
     * @param OrderNoteRepository $repository
     * @param OrderNoteValidator $validator
     */
    public function __construct(OrderNoteRepository $repository, OrderNoteValidator $validator)
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
        $orderNotes = $this->repository->all();

        if ($request->wantsJson()) {
            return $this->response->collection($orderNotes, new OrderNoteTransformer);
        }

        return view('orderNotes.index', compact('orderNotes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderNoteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OrderNoteCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $orderNote = $this->repository->auth()->user()->create($request->all());

            if ($request->wantsJson()) {
                return $this->response->item($orderNote, new OrderNoteTransformer);
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
        $orderNote = $this->repository->find($id);

        if ($request->wantsJson()) {
            return $this->response->item($orderNote, new OrderNoteTransformer);
        }

        return view('orderNotes.show', compact('orderNote'));
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
        $orderNote = $this->repository->find($id);

        if ($request->wantsJson()) {
            return $this->response->item($orderNote, new OrderNoteTransformer);
        }

        return view('orderNotes.edit', compact('orderNote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderNoteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OrderNoteUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $orderNote = $this->repository->update($request->all(), $id);

            if ($request->wantsJson()) {
                return $this->response->item($orderNote, new OrderNoteTransformer);
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
                'message' => 'OrderNote deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OrderNote deleted.');
    }
}

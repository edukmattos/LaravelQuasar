<?php

namespace App\Api\V1\Controllers;

#use App\Http\Requests;

use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use App\Api\V1\Validators\CompanyValidator;
use App\Api\V1\Repositories\CompanyRepository;
use App\Api\V1\Transformers\CompanyTransformer;

use App\Api\V1\Http\Requests\CompanyCreateRequest;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CompaniesController.
 *
 * @package namespace App\Api\V1\Controllers;
 */
class CompaniesController extends Controller
{
    use Helpers;
    
    /**
     * @var CompanyRepository
     */
    protected $repository;

    /**
     * @var CompanyValidator
     */
    protected $validator;

    /**
     * @var CompanyTransformer
     */
    protected $transformer;

    /**
     * CompaniesController constructor.
     *
     * @param CompanyRepository $repository
     * @param CompanyValidator $validator
     */
    public function __construct(CompanyRepository $repository, CompanyValidator $validator, CompanyTransformer $transformer)
    {
        $this->repository   = $repository;
        $this->validator    = $validator;
        $this->transformer  = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $companies = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $companies,
            ]);
        }

        return view('companies.index', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(Request $request)
    {
        try {
            
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            
            $request['uuid'] = Uuid::generate(4);
            
            $company = $this->repository->create($request->all());
            
            $company = $this->repository->find($company->id);

            $request->user()->companies()->save($company);

            if ($request->wantsJson()) {
                return $this->response->item($company, new CompanyTransformer);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => '422 Unprocessable Entity',
                    'errors' => $e->getMessageBag(),
                    'status_code' => 422
                ], 422);
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
        $company = $this->repository->find($id);

        if (request()->wantsJson()) {
            return (new CompanyTransformer)->transform($company);
        }

        return view('companies.show', compact('company'));
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
        $company = $this->repository->find($id);

        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CompanyUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $company = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Company updated.',
                'data'    => $company->toArray(),
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
                'message' => 'Company deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Company deleted.');
    }
}

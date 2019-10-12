<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Events\Tenant\TenantWasCreated;
use App\Repositories\CompanyRepository;
use App\Repositories\BusinessTypeRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CompaniesController.
 *
 * @package namespace App\Http\Controllers;
 */
class CompaniesController extends Controller
{
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;
    protected $businessTypeRepository;

    /**
     * CompaniesController constructor.
     *
     * @param CompanyRepository $companyRepository
     * @param CompanyValidator $validator
     */
    public function __construct(CompanyRepository $companyRepository, BusinessTypeRepository $businessTypeRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->businessTypeRepository = $businessTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->companyRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $companies = $this->companyRepository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $companies,
            ]);
        }

        return view('companies.index', compact('companies'));
    }

    public function create() 
    {
        $business_types = array(''=>'') + $this->businessTypeRepository
        ->pluck('description', 'id')
        ->all();

        return view('companies.create', compact('business_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CompanyRequest $request)
    {
        try {

            #$this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $company = $this->companyRepository->create($request->all());
    
            $request->user()->companies()->save($company);
    
            event(new TenantWasCreated($company));
    
            return redirect()->route('tenant.switch', $company);
            
            #$response = [
            #    'message' => 'Company created.',
            #    'data'    => $company->toArray(),
            #];

            #if ($request->wantsJson()) {
            #    return response()->json($response);
            #}

            #return redirect()->back()->with('message', $response['message']);
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
        $company = $this->companyRepository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $company,
            ]);
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
        $company = $this->companyRepository->find($id);

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

            $company = $this->companyRepository->update($request->all(), $id);

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
        $deleted = $this->companyRepository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Company deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Company deleted.');
    }
}

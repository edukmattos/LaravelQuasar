<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CompanyUserRequest;
use App\Repositories\CompanyUserRepository;
use App\Transformers\CompanyUserTransformer;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

use Dingo\Api\Routing\Helpers;

/**
 * Class CompanyUsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class CompanyUsersController extends Controller
{
    use Helpers;
    
    /**
     * @var CompanyUserRepository
     */
    protected $companyUserRepository;

    /**
     * CompanyUsersController constructor.
     *
     * @param CompanyUserRepository $companyUserRepository
     * @param CompanyUserValidator $validator
     */
    public function __construct(CompanyUserRepository $companyUserRepository)
    {
        $this->companyUserRepository = $companyUserRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$this->companyUserRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $userCompanies = $this->companyUserRepository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userCompanies,
            ]);
        }

        return view('companyUsers.index', compact('companyUsers'));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user($user_id)
    {
        #dd($user_id);
        #$this->companyUserRepository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        #$userCompanies = $this->companyUserRepository->findByField('user_id', Auth::user()->id);
        $userCompanies = $this->companyUserRepository->findByField('user_id', $user_id);

        #dd($userCompanies->company_id);
        
        if (request()->wantsJson()) {

            #return response()->json([
            #    'data' => $userCompanies,
            #]);
            return $this->response->collection($userCompanies, new CompanyUserTransformer);
        }

        #return view('companies.users.index', compact('userCompanies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyUserRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CompanyUserRequest $request)
    {
        try {

            #$this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $companyUser = $this->companyUserRepository->create($request->all());

            $response = [
                'message' => 'CompanyUser created.',
                'data'    => $companyUser->toArray(),
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
        $companyUser = $this->companyUserRepository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $companyUser,
            ]);
        }

        return view('companyUsers.show', compact('companyUser'));
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
        $companyUser = $this->companyUserRepository->find($id);

        return view('companyUsers.edit', compact('companyUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyUserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CompanyUserUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $companyUser = $this->companyUserRepository->update($request->all(), $id);

            $response = [
                'message' => 'CompanyUser updated.',
                'data'    => $companyUser->toArray(),
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
        $deleted = $this->companyUserRepository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'CompanyUser deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CompanyUser deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $requestData = $request->all();
        $users = $this->userService->getAllWithFilter($requestData);

        return view('admin.users.index', compact('users'));
    }

    /*public function edit(int $id)
    {
        $user = $this->userService->find($id);

        return view('admin.users.edit', compact('user'));
    }*/

    public function update(Request $request, int $id)
    {
        $request->validate([
            'password' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $this->userService->update(
                $this->userService->preparingCreateOrUpdate($request->all()), $id
            );
            DB::commit();

            if (isset($request->type)) {
                return response()->json([
                    'code' => 200,
                    'message' => @trans('common.updated_success')
                ]);
            }
            return redirect()->route('user.index')->with('success', @trans('common.updated_success'));
        } catch (\Exception $exception) {
            DB::rollBack();
            if (isset($request->type)) {
                return response()->json([
                    'code' => 400,
                    'message' => $exception->getMessage()
                ]);
            }

            return redirect()->back()->withInput()->with('error', @trans('common.error') . $exception->getMessage());
        }
    }

    public function passDefault(Request $request, int $id)
    {
        try {
            DB::beginTransaction();
            $request['password'] = config('constants.password-default');
            $this->update($request, $id);

            return redirect()->route('user.index')->with('success', @trans('common.updated_success'));
        } catch (\Exception $exception) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', @trans('common.error') . $exception->getMessage());
        }
    }
}

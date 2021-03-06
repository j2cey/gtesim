<?php

namespace App\Http\Controllers\Authorization;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\Role\UpdateRoleRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Foundation\Application;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Collection|Role[]
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        $roles->load(['permissions']);
        return $roles;

        /*$roles = Role::orderBy('id','DESC')->paginate(5);
        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);*/
    }

    public function fetch(Request $request)
    {
        $roles = Role::orderBy('name','ASC')->get();
        $roles->load(['permissions']);
        return $roles;

        /*$roles = Role::orderBy('id','DESC')->paginate(5);
        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Builder|Model|Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);

        $perm_list = [];
        foreach ($request->input('permissions') as $perm) {
            $perm_list[] = $perm["name"];
        }

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($perm_list);

        return $role->load(['permissions']);

        /*return redirect()->route('roles.index')
            ->with('success','Role created successfully');*/
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param int $id
     * @return void
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        /*$this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);*/

        $role = Role::find($id);
        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        $role->syncPermissions($request->input('permissions'));

        return $role->load(['permissions']);

        /*return redirect()->route('roles.index')
            ->with('success','Role updated successfully');*/
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
            ->with('success','Role deleted successfully');
    }

    public function permissions() {
        return Permission::all();
    }

    public function hasrole($roleid) {
        $user = auth()->user();

        $role = Role::where('id', $roleid)->first();

        $hasrole = $role ? ( $user->hasRole([$role->name]) ? 1 : 0 ) : 0;

        return $hasrole;
    }
}

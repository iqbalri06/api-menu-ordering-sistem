<?php

namespace App\Http\Controllers\Modules\Role;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RoleController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        try {
            $data = role::all();
            return $this->appResponse(100, $data); 
        } catch (\Exception $err) {
            return $this->appResponse(2000, $err->getMessage()); 
        }
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
            ]); 

            // Menyimpan data ke dalam tabel role
            $data = Role::create([
                'name' =>  $request->name,
                'description' =>  $request->description,
            ]);


            return $this->appResponse(500, $data);
        } catch (\Exception $err) {
            return $this->appResponse(2000, $err->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required',
            ]);
          
            Role::where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
              $data = Role::findOrFail($id);
                return $this->appResponse(501, $data);
        } catch (\Exception $err) {
            return $this->appResponse(2000, $err->getMessage());
        }
    }
}

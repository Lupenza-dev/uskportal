<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member\Member;
use App\Models\Member\IdType;
use App\Http\Requests\MemberStoreRequest;
use Auth;
use Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Hash;


class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members =Member::orderBy('first_name','ASC')->get();
        $id_types =IdType::get();
        return view('members.list',compact('members','id_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberStoreRequest $request)
    {

        $valid_data =$request->validated();
        $member =Member::create($valid_data + [
            'uuid'       =>(string)Str::ordereduuid(),
            'created_by' =>Auth::user()->id,
            'member_reg_id' =>"USK".mt_rand(00001 ,99999)
        ]);

        $user =User::create([
            'name'         =>$member->first_name.' '.$member->last_name,
            'email'        =>$member->email,
            'phone_number' =>$member->phone_number,
            'member_id'    =>$member->id,
            'password'     =>Hash::make(123456),
            'uuid'         =>(string)Str::ordereduuid(),
        ]);

        $user->assignRole('Member');

        return response()->json([
            'success' =>true,
            'message' =>'Member registered successfullly',

        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $member =Member::where('uuid',$uuid)->first();
        return view('members.profile',compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateMember(Request $request){
        $valid =$this->validate($request,[
            'first_name'   =>'required',
            'middle_name'  =>'required',
            'last_name'    =>'required',
            'phone_number' =>'required',
            'email'      =>'required',
            'dob'        =>'required',
            'id_type_id' =>'required',
            'id_number'  =>'required',
            'uuid'       =>'required',
        ]);

        $member =Member::where('uuid',$valid['uuid'])->update([
            'first_name'  =>$valid['first_name'],
            'middle_name' =>$valid['middle_name'],
            'last_name'   =>$valid['last_name'],
            'dob'          =>$valid['dob'],
            'phone_number' =>$valid['phone_number'],
            'id_type_id'   =>$valid['id_type_id'],
            'id_number'    =>$valid['id_number'],
        ]);

        return response()->json([
            'success' =>true,
            'message' =>'Member Updated successfullly',
        ],200);
        
    }
}

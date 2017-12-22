<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Member;
use App\Models\M3Result;
use DB;

class MemberController extends Controller
{

    /**
     * 申请列表
     * @return [type] [description]
     */
    public function apply(){
        $data = DB::table('apply')->orderBy('time','desc')->paginate(15);
        return view('admin.apply',['data' => $data]);
    }

    /**
     * 申请详细
     * @param  string $id [description]
     * @return [type]     [description]
     */
    public function doApply($id = ''){
        if($id){
            $data = DB::table('apply')->find($id);
            return view('admin.to_apply', ['data' => $data]);
        }
    }

    public function toDoApply(Request $request){
        if($input = $request->except('_token')){

            $uid = $input['id'];
            unset($input['id']);
            if($input['status'] == '1'){
                DB::beginTransaction();
                try {
                    DB::table('user')->where('id',$uid)->update(['active' => 1]);
                    DB::table('apply')->where('user_id',$uid)->update($input);
                    DB::commit();
                    return '200';
                } catch (Exception $e) {
                    DB::rollback();
                    return '401';
                }
            }

            $status = DB::table('apply')->where('user_id',$uid)->update($input);
            return $status?'200':'400';
        }
    }

    /**
     * 会员列表
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function toMember(Request $request)
    {
        $members = DB::table('user')->orderBy('id','desc')->paginate(15);
        return view('admin.member')->with('members', $members);
    }

    public function toMemberEdit(Request $request)
    {
        $id = $request->input('id', '');
        $member = Member::find($id);
        return view('admin.member_edit')->with('member', $member);
    }

    public function memberEdit(Request $request)
    {
        $member = Member::find($request->input('id', ''));

        $member->nickname = $request->input('nickname', '');
        $member->phone = $request->input('phone', '');
        $member->email = $request->input('email', '');
        $member->save();

        $m3_result = new M3Result;
        $m3_result->status = 0;
        $m3_result->message = '添加成功';

        return $m3_result->toJson();
    }



}

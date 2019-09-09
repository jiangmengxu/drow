<?php

namespace App\Http\Controllers\drow;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\DrowModel;
class DrowController extends Controller
{
   //抽奖页面
	public function index()
	{
		return view('drow/index');
	}


	public function add()
	{
		$uid=mt_rand(1,10000);
		// $uid=2;
		$record = DrowModel::where('uid',$uid)->get()->toArray();
		$count=0;
		foreach ($record as $key => $value) {
			if($value['level']>0){
				$leven=0;
				$msg='您已经中奖';
				$responce =[
					'errno'=>0,
					'msg'=>'ok',
					'data'=>[
						'level'=>$level,
						'msg'=>$msg
					]
				];
				die(json_encode($responce));
			}
			$count++;
		}

		if($count>=3){
            $response = [
                'errno' => 0,
                'msg'   => 'ok',
                'data'  => [
                    'level' => 0,
                    'msg'   => "抽奖次数已用光"
                ]
            ];
            die(json_encode($response));
        }
        $prize = $this->getlevel();
        $data = [
            'uid'   => $uid,
            'level' => $prize['level'],
        ];
        $response = [
            'errno' => 0,
            'msg'   => 'ok',
            'data'  => [
                'level' => $prize['level'],
                'msg'   => $prize['msg']
            ]
        ];
		DrowModel::insertGetId($data);
        echo json_encode($response);
	}



	public function getlevel()
	{
		$rand_number = mt_rand(1,100);
        // $rand_number = 2;
        
        if($rand_number==1){
            $count = DrowModel::where(['level'=>1])->count();
            if($count==1){
                $level = 0;
                $msg = "未中奖";
            }else{
                $level = 1;           
                $msg = "恭喜 一等奖";
            }
        }elseif($rand_number==2 || $rand_number==3)
        {
            $count = DrowModel::where(['level'=>2])->count();
            if($count==2){
                $level = 0;
                $msg = "未中奖";
            }else{
                $level =  2;           
                $msg = "恭喜 二等奖";
            }
        }elseif($rand_number==4 || $rand_number==5 || $rand_number==6)
        {
            $count = DrowModel::where(['level'=>3])->count();
            if($count==3){
                $level = 0;
                $msg = "未中奖";
            }else{
                $level =  3;           
                $msg = "恭喜 三等奖";
            }
        }elseif($rand_number>6 && $rand_number<17)
        {
            $count = DrowModel::where(['level'=>4])->count();
            if($count==10){
                $level = 0;
                $msg = "未中奖";
            }else{
                $level =  4;           
                $msg = "恭喜 阳光普照奖";
            }
        }else{
            $level = 0;         
            $msg = "未中奖";
        }
        return [
            'level' => $level,
            'msg'   => $msg
        ];
    }
	
}

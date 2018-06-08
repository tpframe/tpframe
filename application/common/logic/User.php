<?php
// +----------------------------------------------------------------------
// | Author: yaoyihong <510974211@qq.com>
// +----------------------------------------------------------------------
namespace app\common\logic;
use think\Db;
use tpfcore\Core;
use tpfcore\helpers\StringHelper;
/**
 * 用户逻辑
 */
class User extends LogicBase
{
    public function login($data){
        if(self::getStatistics(["username"=>$data['username'],"password"=>"###".$data['password']])==0){
            return [40044,"用户名或密码错误"];
        }else{
            /*
                走这里表示登录成功，登录成功要进行的处理
                1、更新登录标识token并返回回去（不重复的一个串）、以后须要登录后才能操作的地方都须要进行此验证
                2、返回用户其它数据，根据实际情况返回
            */
            $token=md5(StringHelper::get_random_string(20).time().rand(1000,99999));
            Core::loadModel($this->name)->saveObject(["username"=>$data['username']],["token"=>$token]);      //更新用户token,同时更新最后登录时间（model自动完成）
            // 如果要返回用户相关信息，就要查询一下用户的其它数据(我这里举例，查询出昵称、积分、余额)
            $list=self::getList([
                "where"=>["username"=>$data['username']],
                "field"=>"nickname,score,money"
            ]);
            return [0,"登录成功","data"=>[
                            "token"=>$token,
                            "nickname"=>$list[0]['nickname'],
                            "score"=>$list[0]['score'],
                            "money"=>$list[0]['money']
                        ]
                    ];
        }
    }
}

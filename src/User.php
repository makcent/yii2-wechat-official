<?php

namespace makcent\wechat\official;

class User extends Instance
{
    /**
     * 获取用户基本信息(UnionID机制)
     * @param string $access_token
     * @param string $openid
     * @param string $lang
     * @return array
     */
    public function info(string $access_token,string $openid, string $lang = 'zh_CN') : array
    {
        return $this->request('cgi-bin/user/info',[
            'access_token' => $access_token,
            'openid'       => $openid,
            'lang'         => $lang
        ]);
    }

    /**
     * 批量获取用户信息
     * @param string $access_token
     * @param array $users
     * @param string $lang
     * @return array
     */
    public function batchInfo(string $access_token, array $users, string $lang = 'zh_CN') : array
    {
        return $this->request('cgi-bin/user/info/batchget',[
            'access_token' => $access_token
        ],[
            'user_list' => array_map(function($openid) use ($lang) {
                return [ 'openid' => $openid, 'lang'   => $lang];
            },$users)
        ]);
    }


}
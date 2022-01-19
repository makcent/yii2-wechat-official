<?php

namespace makcent\wechat\official;

class User extends Instance
{
    /**
     * 获取用户基本信息(UnionID机制)
     * @param string $openid
     * @param string $lang
     * @return array
     */
    public function info(string $openid, string $lang = 'zh_CN') : array
    {
        return $this->request('cgi-bin/user/info',[
            'access_token' => self::$ACCESS_TOKEN,
            'openid'       => $openid,
            'lang'         => $lang
        ]);
    }

    /**
     * 批量获取用户信息
     * @param array $users
     * @param string $lang
     * @return array
     */
    public function batchInfo(array $users, string $lang = 'zh_CN') : array
    {
        return $this->request('cgi-bin/user/info/batchget',[
            'access_token' => self::$ACCESS_TOKEN
        ],[
            'user_list' => array_map(function($openid) use ($lang) {
                return [ 'openid' => $openid, 'lang'   => $lang];
            },$users)
        ]);
    }


}
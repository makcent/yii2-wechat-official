<?php

namespace makcent\wechat\official;

class Auth extends Instance
{
    /**
     * 获取access_token
     * @return array
     */
    public function getAccessToken()
    {
        return $this->request('cgi-bin/token',[
            'grant_type' => 'client_credential',
            'appid'      => $this->appid,
            'secret'     => $this->secret
        ]);
    }

}
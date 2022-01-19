<?php

namespace makcent\wechat\official;

class Menu extends Instance
{
    /**
     * 创建接口
     * @param string $access_token
     * @param array $params
     * @return array
     */
    public function create(string $access_token,array $params) : array
    {
        return $this->request('cgi-bin/menu/create',[
            'access_token' => $access_token,
        ],json_encode($params,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 查询接口
     * @param string $access_token
     * @return array
     */
    public function menus(string $access_token) : array
    {
        return $this->request('cgi-bin/get_current_selfmenu_info',[
            'access_token' => $access_token,
        ]);
    }

    /**
     * 删除接口
     * @param string $access_token
     * @return array
     */
    public function delete(string $access_token) : array
    {
        return $this->request('cgi-bin/menu/delete',[
            'access_token' => $access_token,
        ]);
    }
}
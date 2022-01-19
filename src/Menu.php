<?php

namespace makcent\wechat\official;

class Menu extends Instance
{
    /**
     * 创建接口
     * @param array $params
     * @return array
     */
    public function create(array $params) : array
    {
        return $this->request('cgi-bin/menu/create',[
            'access_token' => self::$ACCESS_TOKEN,
        ],json_encode($params,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 查询接口
     * @return array
     */
    public function menus() : array
    {
        return $this->request('cgi-bin/get_current_selfmenu_info',[
            'access_token' => self::$ACCESS_TOKEN,
        ]);
    }

    /**
     * 删除接口
     * @return array
     */
    public function delete() : array
    {
        return $this->request('cgi-bin/menu/delete',[
            'access_token' => self::$ACCESS_TOKEN,
        ]);
    }
}
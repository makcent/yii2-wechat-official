<?php

namespace makcent\wechat\official;

class Media extends Instance
{
    /**
     * 上传临时素材文件
     * @param string $access_token
     * @param string $mode
     * @param string $media
     * @return array
     */
    public function uploadMedia(string $access_token, string $mode, string $media) : array
    {
        return $this->request('cgi-bin/media/upload',[
            'access_token' => $access_token,
            'type'      => $mode,
        ],[
            'media' => new \CURLFile(realpath($media))
        ]);
    }

    /**
     * 获取临时素材
     * @param string $access_token
     * @param string $mediaId
     * @param string $filePath
     * @return array
     */
    public function getMedia(string $access_token, string $mediaId, string $filePath) : array
    {
        $conent = $this->request('cgi-bin/media/get',[
            'access_token' => $access_token,
            'media_id'      => $mediaId,
        ],[],true);

        if (isset($conent['content']['errmsg'])) {
            return $conent;
        }

        if (isset($conent['content']['video_url'])) {
            $pathinfo = pathinfo($conent['content']['video_url']);
            $this->curlStreamFile($conent['content']['video_url'],"{$filePath}.{$pathinfo['extension']}");
        }else{
            preg_match('/filename="(.*?)"/is',$conent['headers'],$mime);
            $pathinfo = pathinfo($mime[1]);
            file_put_contents("{$filePath}.{$pathinfo['extension']}",$conent['content']);
        }

        $filename = md5(uniqid(microtime(true) . mt_rand())).'.'.$pathinfo['extension'];
        $conent['content']['filename'] = "{$filePath}/{$filename}";
        return $conent;
    }

    /**
     * 上传永久图文素材
     * @param string $access_token
     * @param array $articles
     * @return array
     */
    public function uploadNewsMaterial(string $access_token, array $articles) : array
    {
        return $this->request('cgi-bin/material/add_news',[
            'access_token' => $access_token
        ],[
            'articles' => $articles
        ]);
    }

    /**
     * 新增其他类型永久素材
     * @param string $access_token
     * @param array $mode
     * @param string $media
     * @return array
     */
    public function uploadOtherMaterial(string $access_token, array  $mode, string $media) : array
    {
        return $this->request('cgi-bin/material/add_material',[
            'access_token' => $access_token,
            'type'      => $mode,
        ],[
            'media' => new \CURLFile(realpath($media))
        ]);
    }

    /**
     * 上传图文消息内的图片获取URL
     * @param string $access_token
     * @param string $media
     * @return array
     */
    public function uploadImageMaterial(string $access_token, string $media) : array
    {
        return $this->request('cgi-bin/media/uploadimg',[
            'access_token' => $access_token
        ],[
            'media' => new \CURLFile(realpath($media))
        ]);
    }

    /**
     * 获取永久素材
     * @param string $access_token
     * @param string $mediaId
     * @return array
     */
    public function getMaterial(string $access_token, string $mediaId)
    {
        return $this->request('cgi-bin/material/get_material',[
            'access_token' => static::getAccessToken()
        ],[
            'media_id'      => $mediaId,
        ]);
    }

    /**
     * 删除永久素材
     * @param string $access_token
     * @param string $mediaId
     * @return array
     */
    public function delMaterial(string $access_token, string $mediaId)
    {
        return $this->request('cgi-bin/material/del_material',[
            'access_token' => static::getAccessToken()
        ],[
            'media_id'      => $mediaId,
        ]);
    }
}
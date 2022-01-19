<?php

namespace makcent\wechat\official;

class Media extends Instance
{
    /**
     * 上传临时素材文件
     * @param string $mode
     * @param string $media
     * @return array
     */
    public function uploadMedia(string $mode, string $media) : array
    {
        return $this->request('cgi-bin/media/upload',[
            'access_token' => self::$ACCESS_TOKEN,
            'type'      => $mode,
        ],[
            'media' => new \CURLFile(realpath($media))
        ]);
    }

    /**
     * 获取临时素材
     * @param string $mediaId
     * @param string $filePath
     * @return array
     */
    public function getMedia(string $mediaId, string $filePath) : array
    {
        $content = $this->request('cgi-bin/media/get',[
            'access_token' => self::$ACCESS_TOKEN,
            'media_id'      => $mediaId,
        ],[],true);

        if (isset($content['content']['errmsg'])) {
            return $content;
        }

        $filename = md5(uniqid(microtime(true) . mt_rand()));
        if (isset($content['content']['video_url'])) {
            $pathinfo = pathinfo($content['content']['video_url']);
            $this->curlStreamFile($content['content']['video_url'],"{$filePath}/{$filename}.{$pathinfo['extension']}");
        }else{
            preg_match('/filename="(.*?)"/is',$content['headers'],$mime);
            $pathinfo = pathinfo($mime[1]);
            file_put_contents("{$filePath}/{$filename}.{$pathinfo['extension']}",$content['content']);
        }
        $content['content']['filename'] = "{$filePath}/{$filename}.{$pathinfo['extension']}";
        return $content;
    }

    /**
     * 上传永久图文素材
     * @param array $articles
     * @return array
     */
    public function uploadNewsMaterial(array $articles) : array
    {
        return $this->request('cgi-bin/material/add_news',[
            'access_token' => self::$ACCESS_TOKEN
        ],[
            'articles' => $articles
        ]);
    }

    /**
     * 新增其他类型永久素材
     * @param array $mode
     * @param string $media
     * @return array
     */
    public function uploadOtherMaterial(array  $mode, string $media) : array
    {
        return $this->request('cgi-bin/material/add_material',[
            'access_token' => self::$ACCESS_TOKEN,
            'type'      => $mode,
        ],[
            'media' => new \CURLFile(realpath($media))
        ]);
    }

    /**
     * 上传图文消息内的图片获取URL
     * @param string $media
     * @return array
     */
    public function uploadImageMaterial(string $media) : array
    {
        return $this->request('cgi-bin/media/uploadimg',[
            'access_token' => self::$ACCESS_TOKEN
        ],[
            'media' => new \CURLFile(realpath($media))
        ]);
    }

    /**
     * 获取永久素材
     * @param string $mediaId
     * @return array
     */
    public function getMaterial(string $mediaId)
    {
        return $this->request('cgi-bin/material/get_material',[
            'access_token' => self::$ACCESS_TOKEN
        ],[
            'media_id'      => $mediaId,
        ]);
    }

    /**
     * 删除永久素材
     * @param string $mediaId
     * @return array
     */
    public function delMaterial(string $mediaId)
    {
        return $this->request('cgi-bin/material/del_material',[
            'access_token' => self::$ACCESS_TOKEN
        ],[
            'media_id'      => $mediaId,
        ]);
    }
}
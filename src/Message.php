<?php

namespace makcent\wechat\official;

class Message extends Instance
{
    private $template = array(
        'text' => <<<EOF
                    <xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[text]]></MsgType>
                      <Content><![CDATA[%s]]></Content>
                    </xml>
EOF,
        'image' => <<<EOF
                    <xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[image]]></MsgType>
                      <Image>
                        <MediaId><![CDATA[%s]]></MediaId>
                      </Image>
                    </xml>
EOF,
        'voice' => <<<EOF
                    <xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[voice]]></MsgType>
                      <Voice>
                        <MediaId><![CDATA[%s]]></MediaId>
                      </Voice>
                    </xml>
EOF,
        'video' => <<<EOF
                    <xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[video]]></MsgType>
                      <Video>
                        <MediaId><![CDATA[%s]]></MediaId>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                      </Video>
                    </xml>
EOF,
        'music' => <<<EOF
                    <xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[music]]></MsgType>
                      <Music>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <MusicUrl><![CDATA[%s]]></MusicUrl>
                        <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                        <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
                      </Music>
                    </xml>
EOF,
        'news' => <<<EOF
                    <xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime>%s</CreateTime>
                      <MsgType><![CDATA[news]]></MsgType>
                      <ArticleCount>%s</ArticleCount>
                      <Articles>%s</Articles>
                    </xml>
EOF,
        'news_item' => <<<EOF
                    <item>
                      <Title><![CDATA[%s]]></Title>
                      <Description><![CDATA[%s]]></Description>
                      <PicUrl><![CDATA[%s]]></PicUrl>
                      <Url><![CDATA[%s]]></Url>
                    </item>
EOF

    );

    /**
     * 回复文本消息
     * @param $request_xml
     * @param $content
     * @return string
     */
    public function textMessage($request_xml,$content)
    {
        return sprintf($this->template['text'],$request_xml->FromUserName,$request_xml->ToUserName,time(),$content);
    }

    /**
     * 回复图像消息
     * @param $request_xml
     * @param $mediaId
     * @return string
     */
    public function imageMessage($request_xml,$mediaId)
    {
        return sprintf($this->template['image'],$request_xml->FromUserName,$request_xml->ToUserName,time(),$mediaId);
    }

    /**
     * 回复语音消息
     * @param $request_xml
     * @param $title
     * @param $description
     * @param $mediaId
     * @return string
     */
    public function voiceMessage($request_xml,$title,$description,$mediaId)
    {
        return sprintf($this->template['voice'],$request_xml->FromUserName,$request_xml->ToUserName,time(),$mediaId,$title,$description);
    }

    /**
     * 回复音乐消息
     * @param $request_xml
     * @param $title
     * @param $description
     * @param $mediaId
     * @param $musicUrl
     * @param $hqMusicUrl
     * @param $thumbMediaId
     * @return string
     */
    public function musicMessage($request_xml,$title,$description,$mediaId,$musicUrl,$hqMusicUrl,$thumbMediaId)
    {
        return sprintf($this->template['music'],$request_xml->FromUserName,$request_xml->ToUserName,time(),$mediaId,$title,$description,$musicUrl,$hqMusicUrl,$thumbMediaId);
    }

    /**
     * 回复图文消息
     * @param $request_xml
     * @param $news
     * array('title'=>'标题','desc'=>'描述','picurl'=>'图片地址','url'=>'该文章的地址'),
     * @return string
     */
    public function newsMessage($request_xml,$news = array())
    {
        $news_items = '';
        foreach ($news as $item) {
            $news_items .= sprintf($this->template['news_item'],$item['title'], $item['desc'],$item['picurl'],$item['url']);
        }
        return sprintf($this->template['news'],$request_xml->FromUserName,$request_xml->ToUserName,time(),count($news),$news_items);
    }

}
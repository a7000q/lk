<?php
namespace frontend\components;


use yii\base\Component;
use linslin\yii2\curl;

class SCurl extends Component
{
    const TOKEN = "81dc9bdb52d04dc20036dbd8313ed055";
    const URL = "http://tateco-cards.ru/index.php";

    public function get($params)
    {
        $curl = new curl\Curl();
        $url_string = $this::URL."?";
        $operand = "";

        foreach ($params as $key => $value)
        {
            $url_string .= $operand.$key."=".$value;
            $operand = "&";
        }

        $url_string .= "&token=".$this::TOKEN;

        $response = $curl->get($url_string);

        return json_decode($response);
    }

    public function getContent($params)
    {
        $curl = new curl\Curl();
        $url_string = $this::URL."?";
        $operand = "";

        foreach ($params as $key => $value)
        {
            $url_string .= $operand.$key."=".$value;
            $operand = "&";
        }

        $url_string .= "&token=".$this::TOKEN;

        $response = $curl->get($url_string);

        return $response;
    }
}
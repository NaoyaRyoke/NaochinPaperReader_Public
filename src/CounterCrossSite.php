<?php
    namespace App;
    class CounterCrossSite
    {
        /*
         * 入力された配列に対してクロスサイトスクリプティング対策を行う
         * 
         * 毎回連想配列に変換して送信しなきゃいけないのめんどくさくないか
         * 
         * @param $row_data [array] : 連想配列でエンティティしたい文字列を受け取る
         * @return [mixed]
         * 成功した場合，入力と同じ形でエンティティされたものが帰ってくる
         * 失敗した場合はfalseが帰ってくる
        */
        public function replace(array $row_data): mixed
        {
            if(!isset($row_data)){
                return false;
            }
            $result = [];
            foreach($row_data as $key => $value){
                $mb_code = mb_detect_encoding($value);
                $value = mb_convert_encoding($value, "utf-8", $mb_code);

                $value = htmlentities($value, ENT_QUOTES);
                $result[$key] = $value;
            }
            return $result;
        }
    }
?>
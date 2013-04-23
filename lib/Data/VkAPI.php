<?php
    namespace Players\Data;

    class VkAPI {

        public function sendNotification( $uids, $message ){
//            $answer = $VK->api(
//                'secure.sendNotification',
//                array('uids'=>$uids,'message'=>urlencode( $message )));
            return true;
        }
    }
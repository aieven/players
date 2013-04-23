<?php
    /**
        Notifications send
     */
    namespace Players\Script\Cron\Queues;


    use Players\System\Registry;

    class NotificationSendScript extends \Players\Script\Base {

        protected function getTemplate( $userName ){
            return urlencode( <<<HTML
                {$userName}! Доброго дня!"
HTML
            );
        }

        public function run(){
            $RedisModel = new \Players\Model\Redis\Queue( 'players' );
            $serializedPlayers = $RedisModel->pull();
            $players = unserialize( reset( $serializedPlayers ));
            $Notifcation = new \Players\Data\VkAPI();
            foreach( $players as $key => $player ){
                $Notifcation->sendNotification( $player['vk_id'], $this->getTemplate( $key ));
                Registry::instance()->Logger( 'notifications', 'Notification send to ' . $key );
                sleep( 5 );
            }
        }
    }
<?php
    /**
        Clear database
     */
    namespace Players\Script\Cron\Database;

    class ClearDbScript extends \Players\Script\Base {

        const SQL_DELETE_TABLE = <<<SQL
        -- SQL_DELETE_TABLE
    DELETE FROM {{ t("players") }}
SQL;

        public function run(){
            $this->db( 'main' )->query( self::SQL_DELETE_TABLE , array());
        }
    }
<?php

use app\core\Application;

class m0004_create_table_offer_option {
    public function up(){
        $db = Application::$app->db;
        $sql = "CREATE TABLE offer_option (
            id SERIAL PRIMARY KEY,
            launch_date DATE NOT NULL,
            week_counter INT NOT NULL,
            duration INT NOT NULL
        );";
        $db->pdo->exec($sql);
    }

    public function down(){
        $sql = "DROP TABLE offer_option;";
        Application::$app->db->pdo->exec($sql);
    }
}
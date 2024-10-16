<?php

use app\core\Application;

class m0003_photo_offre{
    public function up(){
        $db = Application::$app->$db;
        $sql = "CREATE TABLE photo(
            id SERIAL PRIMARY KEY,
            url_photo VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );";
        $db->pdo->exec($sql);
    }

    public function down(){
        $sql = "DROP TABLE photo;";
        Application::$app->$db->pdo->exec($sql);
    }
}
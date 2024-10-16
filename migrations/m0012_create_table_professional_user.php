<?php

use app\core\Application;

class m0012_create_table_professional_user
{
    public function up() {
        $db = Application::$app->db;
        $sql = "CREATE TABLE professional_user(
            id_pro INT PRIMARY KEY,
            code SERIAL NOT NULL,
            denomination VARCHAR(100) UNIQUE NOT NULL,
            siren VARCHAR(14) UNIQUE NOT NULL,
            mail VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(100) NOT NULL,
            avatarUrl VARCHAR(255) NOT NULL,
            CONSTRAINT professional_user_fk1 FOREIGN KEY (id_pro) REFERENCES account(id),
            CONSTRAINT professional_user_fk2 FOREIGN KEY (mail) REFERENCES user(mail),
            CONSTRAINT professional_user_fk3 FOREIGN KEY (password) REFERENCES user(password),
            CONSTRAINT professional_user_fk4 FOREIGN KEY (avatarUrl) REFERENCES user(avatarUrl)
        );";
        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = Application::$app->db;
        $sql = "DROP TABLE professional_user;";
        $db->pdo->exec($sql);
    }
}
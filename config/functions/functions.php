<?php
    /**
     * @param int $data Los datos enviados.
     * @param string $type El tipo de públicación.
     * @param array $date La fecha de creación.
     * @return string Mensaje de estado.
     */
    function upload_post(array $data, string $type, array $date):string {
        global $db;

        if ($type == "wf") {
            $query = $db -> prepare(
                "INSERT INTO posts (post_title, post_desc, post_img, post_by, post_date)
                 VALUES (:pt, :pd, :pi, :pb, :pdt);"
            );
            $query -> execute(array(
                ':pt' => htmlentities($data["title"]),
                ':pd' => htmlentities($data["desc"]),
                ':pi' => $data["img"],
                ':pb' => $data["by"],
                ':pdt' => $date["year"] . "-" . $date["mon"] . "-" . $date["mday"] . " " . $date["hours"] . ":" . $date["minutes"] . ":" . $date["seconds"]
            ));

            return "<p>Publicación subida sin problemas.</p>";
        } elseif ($type == "nwf") {
            $query = $db -> prepare(
                "INSERT INTO posts (post_title, post_desc, post_by, post_date)
                 VALUES (:pt, :pd, :pb, :pdt);"
            );
            $query -> execute(array(
                ':pt' => htmlentities($data["title"]),
                ':pd' => htmlentities($data["desc"]),
                ':pb' => $data["by"],
                ':pdt' => $date["year"] . "-" . $date["mon"] . "-" . $date["mday"] . " " . $date["hours"] . ":" . $date["minutes"] . ":" . $date["seconds"]
            ));

            return "<p>Publicación subida sin problemas.</p>";
        } else {
            return "<b>Error:</b> El parametro <i>type</i> no puede estar vacío.";
        }
    }

    /**
     * @param string $order Orden de las publicaciones.
     * @return string Los div generados.
     */
    function get_posts(string $order) {
        global $db;

        if ($order == "ASC") {
            $query = $db -> query("SELECT * FROM posts ORDER BY `posts`.`post_id` ASC");
        } elseif ($order == "DESC") {
            $query = $db -> query("SELECT * FROM posts ORDER BY `posts`.`post_id` DESC");
        }

        while ($post = $query -> fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="post" id="<?= $post["post_id"] ?>">
                    <div class="head-post-content">
                        <div class="user">
                            <p class="text"><?= get_user($post["post_by"]) ?></p>
                        </div>
                        <div class="date">
                            <p class="text-date" title="<?= $post["post_date"] ?>">
                                <?php $date = explode(" ", $post["post_date"]); echo $date[0]; ?>
                            </p>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="title-post">
                            <p class="text-title"><b><?= $post["post_title"] ?></b></p>
                        </div>
                        <div class="text-post">
                            <p class="text-desc"><?= $post["post_desc"] ?></p>
                        </div>
                        <?php
                            if ($post["post_img"] != null) { ?>
                                <div class="img-post">
                                    <img src="data:img/jpg;base64,<?= $post["post_img"] ?>" width="300px" height="300px">
                                </div>
                            <?php }
                        ?>
                    </div>
                    <div class="actions">
                        <div class="comments">
                            <?php 
                                $comments = get_comments($post["post_id"]); 
                                echo $comments["count"]; 
                            ?> <i class="fa-solid fa-comment"></i>
                        </div>
                        <div class="likes">
                            <?php
                                echo get_likes($post["post_id"])
                            ?> <i class="fa-solid fa-heart"></i>
                        </div>
                    </div>
                    <div class="comments-section">
                        <div class="add-comment"></div>
                        <div class="comments">

                        </div>
                    </div>
                </div>
        <?php }
    }

    /**
     * @param int $id ID del usuario.
     * @return string Nombre del usuario.
     */
    function get_user(int $id):string {
        global $db;

        $query_user = $db -> prepare("SELECT user_nombre FROM users WHERE user_id = :id");
        $query_user -> execute(array(
            ':id' => $id 
        ));

        return implode("", $query_user -> fetch(PDO::FETCH_ASSOC));
    }

    /**
     * @param int $c_id ID de la públicación.
     * @return int Cantidad de likes.
     */
    function get_likes(int $c_id):int {
        global $db;

        $query = $db -> prepare("SELECT * FROM likes WHERE like_for = :id");
        $query -> execute(array(
            ':id' => $c_id
        ));

        return intval($likes = $query -> rowCount());
    }

    function add_like() {

    }

    /**
     * @param int $c_id ID de la públicación.
     * @return array Contador y comentarios.
     */
    function get_comments(int $c_id):array {
        global $db;
        $pre_data = [];

        $query = $db -> prepare("SELECT * FROM comments WHERE comment_for = :id");
        $query -> execute(array(
            ':id' => $c_id
        ));
        $count = $query -> rowCount();
        while ($comments = $query -> fetch(PDO::FETCH_ASSOC)) {
            array_push($pre_data, $comments);
        }

        return $data = [
            "count" => $count,
            "comments" => $pre_data
        ];
    }

    function add_comment() {

    }
?>
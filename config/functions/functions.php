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
                    <div class="left-content">
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
                                ?> <i class="fa-solid fa-comment" style="color: grey;"></i>
                            </div>
                            <div class="likes">
                                <?php
                                    $like = get_likes($post["post_id"]);
                                    echo $like["likes"];

                                    if (in_array($_SESSION["AUTH"]["id"], $like["liked_by"])) { ?>
                                        <i class="fa-solid fa-heart" style="color: red;"></i>
                                    <?php } else { ?>
                                        <a href="<?= $_SERVER["REQUEST_URI"] ?>&like-to=<?= $post["post_id"] ?>"><i class="fa-solid fa-heart" style="color: grey;"></i></a>
                                    <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="right-content">
                        <div class="comments-section">
                            <div class="add-comment">
                                <form action="" class="add-comment" method="get">
                                    <label for="input-comment">
                                        <textarea type="text" name="input-comment" id="input-comment"></textarea>
                                    </label>
                                    <button type="submit" name="cmt" value="<?= $post["post_id"] ?>">Comentar</button>
                                </form>
                            </div>
                            <div class="comments">
                                <?php
                                    for ($i = 0; $i < count($comments["comments"]); $i++) { ?>
                                        <div class="comment">
                                            <div class="by-comment"><?= get_user($comments["comments"][$i]["comment_by"]) ?></div>
                                            <p class="text-comment"><?= $comments["comments"][$i]["comment"] ?></p>
                                        </div>
                                    <?php }
                                ?>
                            </div>
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
     * @return array Cantidad de likes y validación de like.
     */
    function get_likes(int $c_id):array {
        global $db;

        $query = $db -> prepare("SELECT * FROM likes WHERE like_for = :id");
        $query -> execute(array(
            ':id' => $c_id
        ));

        $data = [
            "likes" => $query -> rowCount(),
            "liked_by" => []
        ];

        // Esto lo hago porque se genera un bug, con el while si solo hay 1 like.
        while ($likes = $query -> fetch(PDO::FETCH_ASSOC)) {
            array_push($data["liked_by"], $likes["like_by"]);
        }

        return $data;
    }

    /**
     * Función para agregar los likes.
     * @param int $id_post ID de la publicación.
     * @param int $id_user ID del usuario.
     */
    function add_like(int $id_post, int $id_user) {
        global $db;

        $query = $db -> prepare(
            "INSERT INTO likes (like_for, like_by) 
             VALUES (:idp, :idu)"
        );
        $query -> execute(array(
            ':idp' => $id_post,
            ':idu' => $id_user
        ));

        header("Location: index.php?order=DESC#$id_post");
        return;
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


    /**
     * @param string $comment Texto comentado por el usuario.
     * @param int $id ID de la públicación.
     * @param int $by ID del usuario que realizó el comentario.
     */
    function add_comment(string $comment, int $id, int $by) {
        global $db;

        $query = $db -> prepare("INSERT INTO comments (comment, comment_for, comment_by) VALUES (:cm, :cmf, :cmb);");
        $query -> execute(array(
            ':cm' => htmlentities($comment),
            ':cmf' => htmlentities($id),
            ':cmb' => htmlentities($by)
        ));
    }
?>
<?php
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
?>
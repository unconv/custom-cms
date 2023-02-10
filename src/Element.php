<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

abstract class Element {
    protected int $id;

    public function save( PDO $db, int $page_id ) {
        if( ! isset( $this->id ) ) {
            $stmt = $db->prepare(
                "INSERT INTO elements (
                    page,
                    type,
                    data,
                    weight
                ) VALUES (
                    :page,
                    :type,
                    :data,
                    :weight
                )"
            );

            $stmt->execute( [
                ":page" => $page_id,
                ":type" => $this->get_element_type()->value,
                ":data" => $this->get_json(),
                ":weight" => 0,
            ] );

            $this->id = $db->lastInsertId();
        }
    }

    public function get_data_from_db( int $element_id, PDO $db ): stdClass {
        $stmt = $db->prepare(
            "SELECT data FROM elements WHERE id = :id"
        );

        $stmt->execute( [
            ":id" => $element_id,
        ] );

        $data = $stmt->fetchColumn();

        return json_decode( $data );
    }

    abstract public function from_db( int $element_id, PDO $db ): static;

    abstract public function get_element_type(): ElementTypes;
}

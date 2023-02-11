<?php
namespace Unconv\CustomCms;
use PDO;
use ReflectionClass;
use stdClass;

abstract class Element {
    protected int $id;

    public function set_id( int $id ) {
        $this->id = $id;
    }

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

    public function render(): string {
        $reflect = new ReflectionClass( $this );

        $template_name = strtolower( $reflect->getShortName() );

        $template = file_get_contents( __DIR__ . "/../templates/solid-state/elements/".$template_name.".html" );

        $properties = static::get_properties( $this );

        foreach( $properties as $property ) {
            $getter = "get_" . $property;
            $placeholder = "{".strtoupper( $property )."}";

            $value = $this->$getter();

            if( is_array( $value ) ) {        
                $rendered = "";
        
                foreach( $value as $element ) {
                    if( $element instanceof stdClass ) {
                        $element_class = static::get_element_class( $element );
                        $element = $element_class::from_json( $element );
                    }
                    $rendered .= $element->render();
                }
        
                $value = $rendered;
            } elseif( $value instanceof Element ) {
                $value = $value->render();
            }

            $template = str_replace(
                $placeholder,
                $value,
                $template
            );
        }

        return $template;
    }

    public function from_db( int $element_id, PDO $db ): static {
        $stmt = $db->prepare(
            "SELECT data FROM elements WHERE id = :id"
        );

        $stmt->execute( [
            ":id" => $element_id,
        ] );

        $data = $stmt->fetchColumn();

        $json_data = json_decode( $data );

        $element = static::from_json( $json_data );

        $element->set_id( $element_id );

        return $element;
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public static function get_properties( $element ): array {
        $class = new ReflectionClass( $element );
        $constructor = $class->getConstructor();

        $parameters = [];

        foreach( $constructor->getParameters() as $parameter ) {
            $parameters[] = $parameter->getName();
        }

        return $parameters;
    }

    public static function get_element_class( stdClass $element ): string {
        foreach( ElementTypes::cases() as $element_type ) {
            if( $element_type->value === $element->_type ) {
                return '\\Unconv\\CustomCms\\' . $element_type->name;
            }
        }

        throw new \Exception( "No element class found for " . json_encode( $element ) );
    }

    public function get_array(): array {
        $array = [
            "_type" => $this->get_element_type(),
        ];

        foreach( static::get_properties( $this ) as $property ) {
            $getter = "get_" . $property;
            $value = $this->$getter();

            if( $value instanceof Element ) {
                $value = $value->get_array();
            } elseif( is_array( $value ) ) {
                $result = [];

                foreach( $value as $item ) {
                    $result[] = $item->get_array();
                }

                $value = $result;
            }

            $array[$property] = $value;
        }

        return $array;
    }

    public static function from_json( stdClass $data ): static {
        $class = static::get_element_class( $data );
        $properties = static::get_properties( $class );

        $arguments = [];

        foreach( $properties as $property_name ) {
            $value = $data->$property_name;

            if( is_array( $value ) ) {
                $result = [];

                foreach( $value as $item ) {
                    $item_class = static::get_element_class( $item );
                    $result[] = $item_class::from_json( $item );
                }

                $value = $result;
            } elseif( $value instanceof stdClass ) {
                $item_class = static::get_element_class( $value );
                $value = $item_class::from_json( $value );
            }

            $arguments[] = $value;
        }

        return new static( ...$arguments );
    }

    abstract public function get_element_type(): ElementTypes;
}

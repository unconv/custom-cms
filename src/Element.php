<?php
namespace Unconv\CustomCms;
use PDO;
use ReflectionClass;
use stdClass;

abstract class Element {
    protected int $id;
    protected ViewContext $context = ViewContext::Edit;

    public static int $global_index = 0;
    public int $index;

    public function set_id( int $id ) {
        $this->id = $id;
    }

    public function set_context( ViewContext $context ) {
        $this->context = $context;
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
                ":type" => $this->get_enum_value(),
                ":data" => $this->get_json(),
                ":weight" => 0,
            ] );

            $this->id = $db->lastInsertId();
        }
    }

    public function render( ?Element $parent = null ): string {
        static::$global_index++;

        if( ! isset( $this->index ) ) {
            $this->index = static::$global_index;
        }

        $template_name = strtolower( $this->get_short_classname() );

        $prefix = "";
        if( $this->context === ViewContext::Edit ) {
            $prefix = "edit-";
        }

        $template = file_get_contents( __DIR__ . "/../templates/solid-state/".$prefix."elements/".$template_name.".html" );

        $properties = static::get_properties( $this );

        foreach( $properties as $property ) {
            $getter = "get_" . $property;
            $placeholder = "{".strtoupper( $property )."}";

            $value = $this->$getter( $this->context );

            if( is_array( $value ) ) {        
                $rendered = "";
        
                foreach( $value as $element ) {
                    if( $element instanceof stdClass ) {
                        $element_class = static::get_element_class( $element );
                        $element = $element_class::from_json( $element );
                    }
                    $rendered .= $element->render( $this );
                }
        
                $value = $rendered;
            } elseif( $value instanceof Element ) {
                $value = $value->render( $this );
            }

            $template = str_replace(
                $placeholder,
                $value,
                $template
            );
        }

        if( $this->context === ViewContext::Edit ) {
            if( isset( $this->id ) ) {
                $template .= '<input type="hidden" name="element[][_id]" value="'.$this->id.'" />';
            }

            if( isset( $parent ) ) {
                $template .= '<input type="hidden" name="element[][_parent]" value="'.$parent->index.'" />';
            }

            $template .= '<input type="hidden" name="element[][_type]" value="'.$this->get_enum_value().'" />';

            $template = str_replace(
                "element[]",
                "element[".$this->index."]",
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
        foreach( ElementType::cases() as $element_type ) {
            if( $element_type->value === $element->_type ) {
                return '\\Unconv\\CustomCms\\' . $element_type->name;
            }
        }

        throw new \Exception( "No element class found for " . json_encode( $element ) );
    }

    public function get_array(): array {
        $array = [
            "_type" => $this->get_enum_value(),
        ];

        foreach( static::get_properties( $this ) as $property ) {
            $getter = "get_" . $property;
            $value = $this->$getter( ViewContext::Edit );

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

    public function get_short_classname(): string {
        $reflection = new ReflectionClass( $this );
        return $reflection->getShortName();
    }

    public function get_enum_value(): int {
        foreach( ElementType::cases() as $case ) {
            if( $case->name === $this->get_short_classname() ) {
                return $case->value;
            }
        }

        throw new \Exception( "No element type found for " . __CLASS__ );
    }
}

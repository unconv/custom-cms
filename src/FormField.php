<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

class FormField extends Element
{
    public function __construct(
        protected string $type,
        protected string $label,
    ) {}

    public function render(): string {
        $id = preg_replace( '/[^a-z_]/' , '', strtolower( $this->label ) );

        $rendered = '<div class="field">';

        $rendered .= '<label for="'.$id.'">'. htmlspecialchars( $this->label ) .'</label>';

        if( $this->type === "textarea" ) {
            $rendered .= '<textarea name="'.$id.'" id="'.$id.'" rows="4"></textarea>';
        } else {
            $rendered .= '<input type="text" name="'.$id.'" id="'.$id.'" />';
        }

        $rendered .= '</div>';

        return $rendered;
    }

    public function from_db( int $element_id, PDO $db ): static {
        $data = $this->get_data_from_db( $element_id, $db );

        return static::from_json( $data );
    }

    public static function from_json( stdClass $data ) {
        return new static(
            type: $data->type,
            label: $data->label,
        );
    }

    public function get_array(): array {
        return [
            "_type" => $this->get_element_type(),
            "type" => $this->type,
            "label" => $this->label,
        ];
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::FormField;
    }
}

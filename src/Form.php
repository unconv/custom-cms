<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

class Form extends Element
{
    protected array $fields = [];

    public function __construct(
        protected string $action,
        protected string $submit_text,
    ) {}

    public function add_field( FormField $field ) {
        $this->fields[] = $field;
    }

    public function render(): string {
        $rendered = '<form method="post" action="'.$this->action.'">
        <div class="fields">';

        foreach( $this->fields as $field ) {
            $rendered .= $field->render();
        }

        $rendered .= '
            </div>
            <ul class="actions">
                <li><input type="submit" value="'.$this->submit_text.'" /></li>
            </ul>
        </form>';

        return $rendered;
    }

    public function from_db( int $element_id, PDO $db ): static {
        $data = $this->get_data_from_db( $element_id, $db );

        return static::from_json( $data );
    }

    public static function from_json( stdClass $data ) {
        $form = new static(
            action: $data->action,
            submit_text: $data->submit_text,
        );

        foreach( $data->fields as $field ) {
            $form->add_field( FormField::from_json( $field ) );
        }

        return $form;
    }

    public function get_array(): array {
        $fields = [];

        foreach( $this->fields as $field ) {
            $fields[] = $field->get_array();
        }

        return [
            "_type" => $this->get_element_type(),
            "action" => $this->action,
            "submit_text" => $this->submit_text,
            "fields" => $fields,
        ];
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::Form;
    }
}

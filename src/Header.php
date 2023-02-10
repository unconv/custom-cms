<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

class Header extends Element
{
    public function __construct(
        private string $heading,
        private string $menu_name,
    ) {}

    public function get_heading(): string {
        return $this->heading;
    }

    public function get_menu_name(): string {
        return $this->menu_name;
    }

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/header.html" );

        $template = str_replace( [
            "{HEADING}",
            "{MENU_NAME}",
        ], [
            $this->get_heading(),
            $this->get_menu_name(),
        ], $template );

        return $template;
    }

    private function get_theme(): string {
        return "solid-state";
    }

    public function from_db( int $element_id, PDO $db ): static {
        $data = $this->get_data_from_db( $element_id, $db );

        return static::from_json( $data );
    }

    public static function from_json( stdClass $data ) {
        return new static(
            heading: $data->heading,
            menu_name: $data->menu_name,
        );
    }

    public function get_array(): array {
        return [
            "_type" => $this->get_element_type(),
            "heading" => $this->get_heading(),
            "menu_name" => $this->get_menu_name(),
        ];
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::Header;
    }
}

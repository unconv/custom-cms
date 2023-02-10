<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

class Menu extends Element
{
    public function __construct(
        private string $title,
        private array $links,
        private string $close_text,
    ) {}

    public function get_title(): string {
        return $this->title;
    }

    public function get_links(): array {
        return $this->links;
    }

    public function get_close_text(): string {
        return $this->close_text;
    }

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/menu.html" );

        $template = str_replace( [
            "{MENU_TITLE}",
            "{MENU_LINKS}",
            "{CLOSE_TEXT}",
        ], [
            $this->get_title(),
            $this->render_links(),
            $this->get_close_text(),
        ], $template );

        return $template;
    }

    public function render_links(): string {
        $links = $this->get_links();

        $rendered = "";

        foreach( $links as $link ) {
            $rendered .= '<li><a href="'.htmlspecialchars( $link->url ).'">'.htmlspecialchars( $link->text ).'</a></li>';
        }

        return $rendered;
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
            title: $data->title,
            links: $data->links,
            close_text: $data->close_text,
        );
    }

    public function get_array(): array {
        return [
            "_type" => $this->get_element_type(),
            "title" => $this->get_title(),
            "close_text" => $this->get_close_text(),
            "links" => $this->get_links(),
        ];
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::Menu;
    }
}

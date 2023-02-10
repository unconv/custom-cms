<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

class Article extends Element
{
    public function __construct(
        private string $image,
        private string $title,
        private string $text,
        private string $link_url,
        private string $link_text,
    ) {}

    public function get_image(): string {
        return $this->image;
    }

    public function get_title(): string {
        return $this->title;
    }

    public function get_text(): string {
        return $this->text;
    }

    public function get_link_url(): string {
        return $this->link_url;
    }

    public function get_link_text(): string {
        return $this->link_text;
    }

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/article.html" );

        $template = str_replace( [
            "{IMAGE}",
            "{TITLE}",
            "{TEXT}",
            "{LINK_URL}",
            "{LINK_TEXT}",
        ], [
            $this->get_image(),
            $this->get_title(),
            $this->get_text(),
            $this->get_link_url(),
            $this->get_link_text(),
        ], $template );

        return $template;
    }

    private function get_theme(): string {
        return "solid-state";
    }

    public function get_array(): array {
        return [
            "_type" => $this->get_element_type(),
            "image" => $this->get_image(),
            "title" => $this->get_title(),
            "text" => $this->get_text(),
            "link_url" => $this->get_link_url(),
            "link_text" => $this->get_link_text(),
        ];
    }

    public function from_db( int $element_id, PDO $db ): static {
        $data = $this->get_data_from_db( $element_id, $db );

        return static::from_json( $data );
    }

    public static function from_json( stdClass $data ) {
        return new Article(
            image: $data->image,
            title: $data->title,
            text: $data->text,
            link_url: $data->link_url,
            link_text: $data->link_text,
        );
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::Article;
    }
}

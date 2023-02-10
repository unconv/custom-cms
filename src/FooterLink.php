<?php
namespace Unconv\CustomCms;
use PDO;
use stdClass;

class FooterLink extends Element
{
    public function __construct(
        private string $type,
        private string $url,
        private string $link_name,
    ) {}

    public function render(): string {
        return '<li class="icon brands fa-'.$this->type.'"><a href="'.$this->url.'">'.$this->link_name.'</a></li>';
    }

    public function from_db( int $element_id, PDO $db ): static {
        $data = $this->get_data_from_db( $element_id, $db );

        return static::from_json( $data );
    }

    public static function from_json( stdClass $data ) {
        return new static(
            type: $data->type,
            url: $data->url,
            link_name: $data->link_name,
        );
    }

    public function get_array(): array {
        return [
            "_type" => $this->get_element_type(),
            "type" => $this->type,
            "url" => $this->url,
            "link_name" => $this->link_name,
        ];
    }

    public function get_json(): string {
        return json_encode( $this->get_array() );
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::FooterLink;
    }
}

<?php
namespace Unconv\CustomCms;

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

    public function get_element_type(): ElementTypes {
        return ElementTypes::Menu;
    }
}

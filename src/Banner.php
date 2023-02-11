<?php
namespace Unconv\CustomCms;

class Banner extends Element
{
    public function __construct(
        private string $heading,
        private string $text,
    ) {}

    public function get_heading(): string {
        return $this->heading;
    }

    public function get_text(): string {
        return $this->text;
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::Banner;
    }
}

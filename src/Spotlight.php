<?php
namespace Unconv\CustomCms;

class Spotlight extends Element
{
    public function __construct(
        private string $class,
        private string $image,
        private string $title,
        private string $text,
        private string $link_url,
        private string $link_text,
    ) {}

    public function get_class(): string {
        return $this->class;
    }

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

    public function get_element_type(): ElementTypes {
        return ElementTypes::Spotlight;
    }
}

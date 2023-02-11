<?php
namespace Unconv\CustomCms;

class MenuLink extends Element
{
    public function __construct(
        private string $url,
        private string $text,
    ) {}

    public function get_url(): string {
        return $this->url;
    }

    public function get_text(): string {
        return $this->text;
    }

    public function render(): string {
        return '<li><a href="'.htmlspecialchars( $this->url ).'">'.htmlspecialchars( $this->text ).'</a></li>';
    }

    public function get_element_type(): ElementTypes {
        return ElementTypes::MenuLink;
    }
}

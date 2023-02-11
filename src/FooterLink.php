<?php
namespace Unconv\CustomCms;

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

    public function get_element_type(): ElementTypes {
        return ElementTypes::FooterLink;
    }
}

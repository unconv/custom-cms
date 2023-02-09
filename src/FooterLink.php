<?php
namespace Unconv\CustomCms;

class FooterLink
{
    public function __construct(
        private string $type,
        private string $url,
        private string $link_name,
    ) {}

    public function render(): string {
        return '<li class="icon brands fa-'.$this->type.'"><a href="'.$this->url.'">'.$this->link_name.'</a></li>';
    }
}

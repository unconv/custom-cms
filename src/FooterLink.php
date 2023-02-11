<?php
namespace Unconv\CustomCms;

class FooterLink extends Element
{
    public function __construct(
        private string $type,
        private string $url,
        private string $link_name,
    ) {}

    public function get_type(): string {
        return $this->type;
    }

    public function get_url(): string {
        return $this->url;
    }

    public function get_link_name(): string {
        return $this->link_name;
    }
}

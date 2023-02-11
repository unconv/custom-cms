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
}

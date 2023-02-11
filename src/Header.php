<?php
namespace Unconv\CustomCms;

class Header extends Element
{
    public function __construct(
        private string $heading,
        private string $menu_name,
    ) {}

    public function get_heading(): string {
        return $this->heading;
    }

    public function get_menu_name(): string {
        return $this->menu_name;
    }
}

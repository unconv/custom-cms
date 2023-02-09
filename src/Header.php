<?php
namespace Unconv\CustomCms;

class Header
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

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/header.html" );

        $template = str_replace( [
            "{HEADING}",
            "{MENU_NAME}",
        ], [
            $this->get_heading(),
            $this->get_menu_name(),
        ], $template );

        return $template;
    }

    private function get_theme(): string {
        return "solid-state";
    }
}

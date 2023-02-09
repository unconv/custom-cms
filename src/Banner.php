<?php
namespace Unconv\CustomCms;

class Banner
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

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/banner.html" );

        $template = str_replace( [
            "{HEADING}",
            "{TEXT}",
        ], [
            $this->get_heading(),
            $this->get_text(),
        ], $template );

        return $template;
    }

    private function get_theme(): string {
        return "solid-state";
    }
}

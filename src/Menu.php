<?php
namespace Unconv\CustomCms;

class Menu
{
    public function __construct(
        private string $title,
        private array $links,
        private string $close_text,
    ) {}

    public function get_title(): string {
        return $this->title;
    }

    public function get_links(): array {
        return $this->links;
    }

    public function get_close_text(): string {
        return $this->close_text;
    }

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/menu.html" );

        $template = str_replace( [
            "{MENU_TITLE}",
            "{MENU_LINKS}",
            "{CLOSE_TEXT}",
        ], [
            $this->get_title(),
            $this->render_links(),
            $this->get_close_text(),
        ], $template );

        return $template;
    }

    public function render_links(): string {
        $links = $this->get_links();

        $rendered = "";

        foreach( $links as $link ) {
            $rendered .= '<li><a href="'.htmlspecialchars( $link['url'] ).'">'.htmlspecialchars( $link['text'] ).'</a></li>';
        }

        return $rendered;
    }

    private function get_theme(): string {
        return "solid-state";
    }
}

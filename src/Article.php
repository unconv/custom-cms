<?php
namespace Unconv\CustomCms;

class Article
{
    public function __construct(
        private string $image,
        private string $title,
        private string $text,
        private string $link_url,
        private string $link_text,
    ) {}

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

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/article.html" );

        $template = str_replace( [
            "{IMAGE}",
            "{TITLE}",
            "{TEXT}",
            "{LINK_URL}",
            "{LINK_TEXT}",
        ], [
            $this->get_image(),
            $this->get_title(),
            $this->get_text(),
            $this->get_link_url(),
            $this->get_link_text(),
        ], $template );

        return $template;
    }

    private function get_theme(): string {
        return "solid-state";
    }
}

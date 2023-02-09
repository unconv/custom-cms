<?php
namespace Unconv\CustomCms;

class ArticleBlock
{
    public function __construct(
        private string $title,
        private string $text,
        private array $articles,
        private string $link_url,
        private string $link_text,
    ) {}

    public function get_title(): string {
        return $this->title;
    }

    public function get_text(): string {
        return $this->text;
    }

    public function get_articles(): array {
        return $this->articles;
    }

    public function get_link_url(): string {
        return $this->link_url;
    }

    public function get_link_text(): string {
        return $this->link_text;
    }

    public function render(): string {
        $template = file_get_contents( __DIR__ . "/../templates/".$this->get_theme()."/elements/articleblock.html" );

        $template = str_replace( [
            "{TITLE}",
            "{TEXT}",
            "{ARTICLES}",
            "{LINK_URL}",
            "{LINK_TEXT}",
        ], [
            $this->get_title(),
            $this->get_text(),
            $this->render_articles(),
            $this->get_link_url(),
            $this->get_link_text(),
        ], $template );

        return $template;
    }

    private function render_articles(): string {
        $articles = $this->get_articles();

        $rendered = "";

        foreach( $articles as $article ) {
            $rendered .= $article->render();
        }

        return $rendered;
    }

    private function get_theme(): string {
        return "solid-state";
    }
}

<?php
namespace Unconv\CustomCms;

class ArticleBlock extends Element
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
}
